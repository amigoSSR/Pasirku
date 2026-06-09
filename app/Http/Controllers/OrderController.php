<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Toko;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * User's Order Tracking Page
     */
    public function userOrders()
    {
        // Include completed orders from today so user can rate them immediately after confirming
        $orders = Pesanan::where('ID_Akun', Auth::id())
            ->where(function($query) {
                $query->whereNotIn('Status_Pesanan', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIBATALKAN])
                      ->orWhere(function($q) {
                          $q->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
                            ->where('updated_at', '>=', now()->subMinutes(60)); // Show for 60 mins after completion
                      });
            })
            ->with('review')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tampilaUntukUser.ordertracking', compact('orders'));
    }

    /**
     * User confirms order completion (only when status = Dikirim).
     */
    public function userCompleteOrder(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::where('ID_Akun', Auth::id())
                ->where('Status_Pesanan', Pesanan::STATUS_DIKIRIM)
                ->lockForUpdate()
                ->findOrFail($id);

            $oldStatus = $pesanan->Status_Pesanan;
            $oldPaymentStatus = $pesanan->Status_Pembayaran;

            $pesanan->Status_Pesanan = Pesanan::STATUS_SELESAI;
            $pesanan->Status_Pembayaran = 'Lunas';

            // Hitung komisi admin 1,05% dari total harga
            $komisiAdmin = (int) floor($pesanan->total_harga * 0.0105);
            $pesanan->komisi_admin = $komisiAdmin;
            $pesanan->save();

            // Update Pendapatan & Total Pembelian & Komisi Admin Toko
            $toko = Toko::where('ID_Toko', $pesanan->ID_Toko)->first();
            if ($toko && $oldPaymentStatus !== 'Lunas') {
                $toko->Pendapatan_Toko += $pesanan->total_harga;
                $toko->Total_Pembelian += 1;
                $toko->Komisi_Admin += $komisiAdmin;
                $toko->save();
            }

            DB::commit();

            // Send auto-notification chat to store
            if ($toko) {
                $this->sendOrderNotificationChat($pesanan, $toko, Pesanan::STATUS_SELESAI);
            }

            return back()->with('success', 'Pesanan telah dikonfirmasi selesai. Terima kasih!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengkonfirmasi pesanan: ' . $e->getMessage());
        }
    }

    /**
     * User's Order History Page (completed & cancelled orders)
     * Supports: pagination, status filter, sort, search
     */
    public function userHistory(Request $request)
    {
        // Update riwayat_seen_at to mark notifications as read
        $user = Auth::user();
        $user->riwayat_seen_at = now();
        $user->save();

        $query = Pesanan::where('ID_Akun', Auth::id())
            ->whereIn('Status_Pesanan', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIBATALKAN]);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'Semua') {
            $statusMap = [
                'Selesai'    => Pesanan::STATUS_SELESAI,
                'Dibatalkan' => Pesanan::STATUS_DIBATALKAN,
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('Status_Pesanan', $statusMap[$request->status]);
            }
        }

        // Search by order ID or product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ID_Pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_produk', 'like', "%{$search}%")
                  ->orWhere('Nama_Toko', 'like', "%{$search}%");
            });
        }

        // Sort order
        $sortOrder = $request->input('sort', 'terbaru');
        $query->orderBy('updated_at', $sortOrder === 'terlama' ? 'asc' : 'desc');

        $orders = $query->paginate(10)->appends($request->query());

        return view('tampilaUntukUser.riwayat', compact('orders'));
    }

    /**
     * Store's Order Management Page
     */
    public function storeOrders()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki toko.');
        }

        $query = Pesanan::where('ID_Toko', $toko->ID_Toko);

        if (request()->has('status') && request()->status !== 'Semua') {
            $statusMap = [
                'Baru'    => Pesanan::STATUS_PENDING,
                'Proses'  => Pesanan::STATUS_DIPROSES,
                'Kirim'   => Pesanan::STATUS_DIKIRIM,
                'Selesai' => Pesanan::STATUS_SELESAI,
            ];
            if (isset($statusMap[request()->status])) {
                $query->where('Status_Pesanan', $statusMap[request()->status]);
            }
        }

        if (request()->filled('search')) {
            $search = request()->search;
            $query->where(function ($q) use ($search) {
                $q->where('ID_Pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_pembeli', 'like', "%{$search}%")
                  ->orWhere('nama_produk', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        $statuses = [
            'total'           => Pesanan::where('ID_Toko', $toko->ID_Toko)->count(),
            'pending'         => Pesanan::where('ID_Toko', $toko->ID_Toko)->where('Status_Pesanan', Pesanan::STATUS_PENDING)->count(),
            'dikirim'         => Pesanan::where('ID_Toko', $toko->ID_Toko)->where('Status_Pesanan', Pesanan::STATUS_DIKIRIM)->count(),
            'selesai_hari_ini'=> Pesanan::where('ID_Toko', $toko->ID_Toko)->where('Status_Pesanan', Pesanan::STATUS_SELESAI)->whereDate('updated_at', today())->count(),
        ];

        // Total komisi admin dari seluruh pesanan selesai milik toko ini
        $totalKomisiAdmin = $toko->Komisi_Admin;

        return view('tampilanPenjualStore.ordertrackingStore', compact('orders', 'statuses', 'totalKomisiAdmin'));
    }

    /**
     * Update Order Status — with auto chat notification to buyer.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'          => 'required|in:pending,accepted,diproses,dikirim,selesai,dibatalkan,Belum Diterima Toko,Diproses,Dikirim,Selesai,Dibatalkan',
            'alasan_tolak'    => 'nullable|string|max:500',
            'info_pengiriman' => 'nullable|string|max:500',
        ]);

        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $pesanan = Pesanan::where('ID_Toko', $toko->ID_Toko)->lockForUpdate()->findOrFail($id);
            $oldStatus = $pesanan->Status_Pesanan;
            $oldPaymentStatus = $pesanan->Status_Pembayaran;

            $newStatus = $request->status;

            // Map status input to model constants
            $statusMap = [
                'pending'                  => Pesanan::STATUS_PENDING,
                'accepted'                 => Pesanan::STATUS_DIPROSES,
                'diproses'                 => Pesanan::STATUS_DIPROSES,
                'dikirim'                  => Pesanan::STATUS_DIKIRIM,
                'selesai'                  => Pesanan::STATUS_SELESAI,
                'dibatalkan'               => Pesanan::STATUS_DIBATALKAN,
                Pesanan::STATUS_PENDING    => Pesanan::STATUS_PENDING,
                Pesanan::STATUS_DIPROSES   => Pesanan::STATUS_DIPROSES,
                Pesanan::STATUS_DIKIRIM    => Pesanan::STATUS_DIKIRIM,
                Pesanan::STATUS_SELESAI    => Pesanan::STATUS_SELESAI,
                Pesanan::STATUS_DIBATALKAN => Pesanan::STATUS_DIBATALKAN,
            ];

            if (isset($statusMap[$newStatus])) {
                $newStatus = $statusMap[$newStatus];
            }

            $pesanan->Status_Pesanan = $newStatus;

            if (in_array($newStatus, [Pesanan::STATUS_DIPROSES, Pesanan::STATUS_DIKIRIM, Pesanan::STATUS_SELESAI])) {
                $pesanan->Status_Pembayaran = 'Lunas';
            } elseif ($newStatus === Pesanan::STATUS_DIBATALKAN) {
                $pesanan->Status_Pembayaran = 'Dibatalkan';
            }

            if ($newStatus === Pesanan::STATUS_DIBATALKAN && $request->filled('alasan_tolak')) {
                $pesanan->alasan_tolak = $request->alasan_tolak;
            }
            if ($newStatus === Pesanan::STATUS_DIKIRIM && $request->filled('info_pengiriman')) {
                $pesanan->info_pengiriman = $request->info_pengiriman;
            }

            // ── Stock Restoration Logic ──────────────────────────────
            if ($newStatus === Pesanan::STATUS_DIBATALKAN && $oldStatus !== Pesanan::STATUS_DIBATALKAN) {
                $cartItems = $pesanan->cart_items;
                if (is_array($cartItems) && count($cartItems) > 0) {
                    foreach ($cartItems as $item) {
                        $key = $item['key'] ?? null;
                        if (!$key) continue;

                        $parts = explode('_', $key);
                        $productId = (int) $parts[0];
                        $type = $item['type'] ?? ($parts[1] ?? 'pickup');
                        $qty = (int) ($item['qty'] ?? 1);

                        // Lock product baris di isi_toko untuk update
                        $product = DB::table('isi_toko')
                            ->where('ID_Isi_Toko', $productId)
                            ->where('ID_Toko', $toko->ID_Toko)
                            ->lockForUpdate()
                            ->first();

                        if ($product) {
                            if ($type === 'pickup') {
                                DB::table('isi_toko')
                                    ->where('ID_Isi_Toko', $productId)
                                    ->increment('Stock_PickUp', $qty);
                            } else {
                                DB::table('isi_toko')
                                    ->where('ID_Isi_Toko', $productId)
                                    ->increment('Stock_Truck', $qty);
                            }

                            // Ambil sisa stok terbaru pasca increment
                            $updatedProduct = DB::table('isi_toko')
                                ->where('ID_Isi_Toko', $productId)
                                ->first();

                            $totalStock = $updatedProduct->Stock_PickUp + $updatedProduct->Stock_Truck;
                            if ($totalStock > 0 && $updatedProduct->Status_Produk === 'habis') {
                                DB::table('isi_toko')
                                    ->where('ID_Isi_Toko', $productId)
                                    ->update(['Status_Produk' => 'tersedia']);
                            }

                            // Catat di log_stok (tipe = masuk)
                            DB::table('log_stok')->insert([
                                'ID_Isi_Toko' => $productId,
                                'tipe'        => 'masuk',
                                'jenis'       => $type,
                                'jumlah'      => $qty,
                                'keterangan'  => "Pengembalian stok otomatis via Pembatalan (Order #{$pesanan->ID_Pesanan}). Alasan: " . ($request->alasan_tolak ?? 'Dibatalkan oleh Toko'),
                                'created_at'  => now(),
                                'updated_at'  => now(),
                            ]);
                        }
                    }
                }
            }

            $pesanan->save();

            // ── Update Pendapatan & Total Pembelian Toko ───────────────
            $newPaymentStatus = $pesanan->Status_Pembayaran;

            if ($oldPaymentStatus !== 'Lunas' && $newPaymentStatus === 'Lunas') {
                // Hitung komisi admin 1,05%
                $komisiAdmin = (int) floor($pesanan->total_harga * 0.0105);
                $pesanan->komisi_admin = $komisiAdmin;

                $toko->Pendapatan_Toko += $pesanan->total_harga;
                $toko->Total_Pembelian += 1;
                $toko->Komisi_Admin += $komisiAdmin;
                $toko->save();
            } elseif ($oldPaymentStatus === 'Lunas' && $newPaymentStatus === 'Dibatalkan') {
                $komisiAdmin = $pesanan->komisi_admin;

                $toko->Pendapatan_Toko -= $pesanan->total_harga;
                $toko->Total_Pembelian = max(0, $toko->Total_Pembelian - 1);
                $toko->Komisi_Admin = max(0, $toko->Komisi_Admin - $komisiAdmin);
                $toko->save();
            }

            DB::commit();

            // ── Auto-send chat notification to buyer ──────────────────────
            if ($oldStatus !== $newStatus) {
                $this->sendOrderNotificationChat($pesanan, $toko, $newStatus, $request->alasan_tolak);
            }

            return back()->with('success', 'Status pesanan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Kirim pesan otomatis dari toko ke user ketika status pesanan berubah.
     */
    private function sendOrderNotificationChat(Pesanan $pesanan, Toko $toko, string $newStatus, ?string $alasan = null): void
    {
        $produk = $pesanan->nama_produk ?? 'produk pasir';

        $messageText = match ($newStatus) {
            'accepted',
            Pesanan::STATUS_DIPROSES => "✅ Halo! Pesanan Anda untuk **{$produk}** (Order #{$pesanan->ID_Pesanan}) telah kami terima dan sedang kami proses. Terima kasih telah berbelanja! 🙏",
            Pesanan::STATUS_DIKIRIM  => "🚚 Pesanan Anda untuk **{$produk}** (Order #{$pesanan->ID_Pesanan}) sedang dalam perjalanan ke lokasi Anda!\n\n" . ($pesanan->info_pengiriman ? "Info pengiriman: {$pesanan->info_pengiriman}" : "Mohon bersiap menerima pengiriman."),
            Pesanan::STATUS_SELESAI  => "🎉 Pesanan **{$produk}** (Order #{$pesanan->ID_Pesanan}) telah selesai! Terima kasih sudah berbelanja di toko kami. Semoga memuaskan!",
            Pesanan::STATUS_DIBATALKAN => "❌ Mohon maaf, pesanan Anda untuk **{$produk}** (Order #{$pesanan->ID_Pesanan}) tidak dapat kami penuhi." . ($alasan ? "\n\nAlasan: {$alasan}" : '') . "\n\nSilakan hubungi kami jika ada pertanyaan.",
            default => null,
        };

        if (!$messageText) {
            return;
        }

        // Ensure a chat room exists between store and user
        $chatExists = Message::where('toko_id', $toko->ID_Toko)
            ->where(function ($q) use ($pesanan, $toko) {
                $q->where('sender_id', $toko->ID_Akun)->where('receiver_id', $pesanan->ID_Akun)
                  ->orWhere('sender_id', $pesanan->ID_Akun)->where('receiver_id', $toko->ID_Akun);
            })->exists();

        if (!$chatExists) {
            // Create an initial message to open the chat room
            Message::create([
                'sender_id'   => $pesanan->ID_Akun,
                'receiver_id' => $toko->ID_Akun,
                'toko_id'     => $toko->ID_Toko,
                'message'     => "Halo, saya memesan produk dari toko Anda (Order #{$pesanan->ID_Pesanan}).",
                'is_read'     => true,
            ]);
        }

        // Send the automated notification message from store to user
        Message::create([
            'sender_id'   => $toko->ID_Akun,
            'receiver_id' => $pesanan->ID_Akun,
            'toko_id'     => $toko->ID_Toko,
            'message'     => $messageText,
            'is_read'     => false,
        ]);
    }

    /**
     * User reports an order — sends report message to Customer Support (admin) and to the store.
     */
    public function reportOrder(Request $request, $id)
    {
        $request->validate([
            'alasan_report' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $pesanan = Pesanan::where('ID_Akun', $user->ID_Akun)->findOrFail($id);
        $toko = Toko::where('ID_Toko', $pesanan->ID_Toko)->first();
        $admin = User::where('Role', 'admin')->first();

        $orderCode = '#ORD-' . str_pad($pesanan->ID_Pesanan, 4, '0', STR_PAD_LEFT);
        $produk = $pesanan->nama_produk ?? 'produk pasir';
        $alasan = $request->alasan_report;

        // ── 1. Send to Customer Support (Admin) ─────────────────────
        if ($admin) {
            $adminMsg = "🚨 *LAPORAN PESANAN*\n\n"
                . "Pesanan: {$orderCode}\n"
                . "Produk: {$produk}\n"
                . "Toko: {$pesanan->Nama_Toko}\n"
                . "Pelapor: {$user->Username}\n\n"
                . "Alasan:\n{$alasan}";

            // Ensure admin chat room exists
            $adminChatExists = Message::whereNull('toko_id')
                ->where(function ($q) use ($user, $admin) {
                    $q->where('sender_id', $user->ID_Akun)->where('receiver_id', $admin->ID_Akun)
                      ->orWhere('sender_id', $admin->ID_Akun)->where('receiver_id', $user->ID_Akun);
                })->exists();

            if (!$adminChatExists) {
                Message::create([
                    'sender_id'   => $user->ID_Akun,
                    'receiver_id' => $admin->ID_Akun,
                    'toko_id'     => null,
                    'message'     => 'Halo Customer Support, saya butuh bantuan.',
                    'is_read'     => true,
                ]);
            }

            Message::create([
                'sender_id'   => $user->ID_Akun,
                'receiver_id' => $admin->ID_Akun,
                'toko_id'     => null,
                'message'     => $adminMsg,
                'is_read'     => false,
            ]);
        }

        // ── 2. Send to Store ────────────────────────────────────────
        if ($toko) {
            $tokoMsg = "🚨 *LAPORAN PESANAN*\n\n"
                . "Pesanan: {$orderCode}\n"
                . "Produk: {$produk}\n"
                . "Pelapor: {$user->Username}\n\n"
                . "Alasan:\n{$alasan}";

            // Ensure store chat room exists
            $tokoChatExists = Message::where('toko_id', $toko->ID_Toko)
                ->where(function ($q) use ($user, $toko) {
                    $q->where('sender_id', $user->ID_Akun)->where('receiver_id', $toko->ID_Akun)
                      ->orWhere('sender_id', $toko->ID_Akun)->where('receiver_id', $user->ID_Akun);
                })->exists();

            if (!$tokoChatExists) {
                Message::create([
                    'sender_id'   => $user->ID_Akun,
                    'receiver_id' => $toko->ID_Akun,
                    'toko_id'     => $toko->ID_Toko,
                    'message'     => "Halo, saya memesan produk dari toko Anda ({$orderCode}).",
                    'is_read'     => true,
                ]);
            }

            Message::create([
                'sender_id'   => $user->ID_Akun,
                'receiver_id' => $toko->ID_Akun,
                'toko_id'     => $toko->ID_Toko,
                'message'     => $tokoMsg,
                'is_read'     => false,
            ]);
        }

        return back()->with('success', 'Laporan berhasil dikirim ke Customer Support dan Toko.');
    }

    /**
     * API: Ambil detail satu pesanan untuk modal di halaman store.
     */
    public function storeOrderDetail($id)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pesanan = Pesanan::where('ID_Toko', $toko->ID_Toko)->findOrFail($id);

        // Hitung komisi admin (jika belum tersimpan, hitung dari total_harga)
        $komisiAdmin = $pesanan->komisi_admin > 0
            ? $pesanan->komisi_admin
            : (int) floor($pesanan->total_harga * 0.0105);

        $pendapatanBersih = $pesanan->total_harga - $komisiAdmin;

        // Parse cart items untuk breakdown produk
        $cartItems = is_array($pesanan->cart_items) ? $pesanan->cart_items : json_decode($pesanan->cart_items ?? '[]', true);

        return response()->json([
            'id'                  => $pesanan->ID_Pesanan,
            'order_code'          => '#ORD-' . str_pad($pesanan->ID_Pesanan, 4, '0', STR_PAD_LEFT),
            'nama_pembeli'        => $pesanan->nama_pembeli ?? $pesanan->Username,
            'nama_produk'         => $pesanan->nama_produk,
            'tipe_pengiriman'     => $pesanan->tipe_pengiriman,
            'lokasi_pengantaran'  => $pesanan->Lokasi_Pengantaran,
            'unit'                => $pesanan->Unit,
            'tanggal_pengiriman'  => $pesanan->Tanggal_Pengiriman ? \Carbon\Carbon::parse($pesanan->Tanggal_Pengiriman)->format('d M Y') : '-',
            'jam_tiba'            => $pesanan->Jam_Tiba ?? '-',
            'total_harga'         => $pesanan->total_harga,
            'total_harga_formatted' => 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.'),
            'komisi_admin'        => $komisiAdmin,
            'komisi_admin_formatted' => 'Rp ' . number_format($komisiAdmin, 0, ',', '.'),
            'pendapatan_bersih'   => $pendapatanBersih,
            'pendapatan_bersih_formatted' => 'Rp ' . number_format($pendapatanBersih, 0, ',', '.'),
            'status_pesanan'      => $pesanan->statusLabel(),
            'status_pembayaran'   => $pesanan->Status_Pembayaran,
            'bukti_pembayaran'    => $pesanan->Bukti_Pembayaran ? route('bukti.image', basename($pesanan->Bukti_Pembayaran)) : null,
            'cart_items'          => $cartItems,
            'created_at'          => $pesanan->created_at->format('d M Y, H:i'),
            'info_pengiriman'     => $pesanan->info_pengiriman,
            'alasan_tolak'        => $pesanan->alasan_tolak,
        ]);
    }
}
