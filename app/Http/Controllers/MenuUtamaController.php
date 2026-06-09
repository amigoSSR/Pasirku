<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Pesanan;
use App\Models\IsiToko;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuUtamaController extends Controller
{
    /**
     * Tampilkan halaman utama dengan daftar toko yang AKTIF saja.
     * Toko inactive tidak akan muncul di homepage maupun pencarian.
     */
    public function index()
    {
        $tokoList = Toko::active()->get();

        return view('tampilaUntukUser.MenuUtama', compact('tokoList'));
    }

    /**
     * Tampilkan halaman dashboard store dengan data nyata dari database.
     */
    public function storeIndex()
    {
        $user = Auth::user();
        $toko = Toko::where('ID_Akun', $user->ID_Akun)->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki toko.');
        }

        // 1. Stats Cards
        $totalPendapatan = $toko->Pendapatan_Toko;

        $totalPesanan = Pesanan::where('ID_Toko', $toko->ID_Toko)->count();

        $pasirTerjual = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
            ->sum('Unit');

        $produkAktif = IsiToko::where('ID_Toko', $toko->ID_Toko)->count();

        // 2. Chart Data (Last 7 days sales)
        $chartLabels = [];
        $chartValues = [];
        $indonesianDays = [
            'Sun' => 'Min',
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab',
        ];

        for ($i = 6; $i >= 0; $i--) {
            $carbonDate = now()->subDays($i);
            $dateStr = $carbonDate->format('Y-m-d');
            $dayName = $carbonDate->format('D');
            $dayLabel = $indonesianDays[$dayName] ?? $dayName;

            $chartLabels[] = $dayLabel;

            $dailySales = Pesanan::where('ID_Toko', $toko->ID_Toko)
                ->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
                ->whereDate('created_at', $dateStr)
                ->sum('total_harga');

            $chartValues[] = $dailySales;
        }

        // 3. Recent Orders
        $recentOrders = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Top Products
        $topProducts = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->whereIn('Status_Pesanan', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIKIRIM, Pesanan::STATUS_DIPROSES])
            ->select('nama_produk', DB::raw('SUM(Unit) as total_sold'))
            ->groupBy('nama_produk')
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get();

        // 5. Store Health
        $completedOrdersCount = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
            ->count();
        $completionRate = $totalPesanan > 0 ? round(($completedOrdersCount / $totalPesanan) * 100) : 100;
        
        $complaintsCount = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', Pesanan::STATUS_DIBATALKAN)
            ->count();

        $unreadChatCount = Message::where('toko_id', $toko->ID_Toko)
            ->where('receiver_id', $user->ID_Akun)
            ->where('is_read', false)
            ->count();

        // 6. Rating Stats
        $averageRating = $toko->averageRating();
        $totalReviews = $toko->reviews()->count();
        $ratingDistribution = $toko->ratingDistribution();
        $recentReviews = $toko->reviews()->with('akun')->latest()->take(5)->get();

        return view('tampilanPenjualStore.MenuUtamaStore', compact(
            'toko',
            'totalPendapatan',
            'totalPesanan',
            'pasirTerjual',
            'produkAktif',
            'chartLabels',
            'chartValues',
            'recentOrders',
            'topProducts',
            'completionRate',
            'complaintsCount',
            'unreadChatCount',
            'averageRating',
            'totalReviews',
            'ratingDistribution',
            'recentReviews'
        ));
    }

    /**
     * Endpoint API untuk mengambil statistik realtime dashboard (AJAX Polling).
     */
    public function statsApi()
    {
        $user = Auth::user();
        $toko = Toko::where('ID_Akun', $user->ID_Akun)->first();
        if (!$toko) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $totalPendapatan = $toko->Pendapatan_Toko;

        $totalPesanan = Pesanan::where('ID_Toko', $toko->ID_Toko)->count();

        $pasirTerjual = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
            ->sum('Unit');

        $produkAktif = IsiToko::where('ID_Toko', $toko->ID_Toko)->count();

        $unreadChatCount = Message::where('toko_id', $toko->ID_Toko)
            ->where('receiver_id', $user->ID_Akun)
            ->where('is_read', false)
            ->count();

        // Top products
        $topProductsData = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->whereIn('Status_Pesanan', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIKIRIM, Pesanan::STATUS_DIPROSES])
            ->select('nama_produk', DB::raw('SUM(Unit) as total_sold'))
            ->groupBy('nama_produk')
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get();

        // Recent orders list formatted
        $recentOrders = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->ID_Pesanan,
                    'buyer' => $order->nama_pembeli ?? $order->Username,
                    'product' => $order->nama_produk ?? 'Pasir',
                    'time' => $order->created_at->diffForHumans(),
                    'status' => $order->statusLabel(),
                    'status_class' => $order->Status_Pesanan === 'Belum Diterima Toko' ? 'Baru' : $order->statusLabel()
                ];
            });

        return response()->json([
            'total_pendapatan' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'),
            'total_pesanan' => number_format($totalPesanan, 0, ',', '.'),
            'pasir_terjual' => number_format($pasirTerjual, 0, ',', '.') . ' m³',
            'produk_aktif' => number_format($produkAktif, 0, ',', '.'),
            'unread_chat' => $unreadChatCount,
            'recent_orders' => $recentOrders,
            'top_products' => $topProductsData
        ]);
    }

    /**
     * Tampilkan halaman monitoring pelanggan untuk store
     */
    public function monitoringPelanggan()
    {
        $user = Auth::user();
        $toko = Toko::where('ID_Akun', $user->ID_Akun)->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki toko.');
        }

        // 1. Stats Cards
        $totalPelanggan = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->distinct('ID_Akun')
            ->count('ID_Akun');

        // Pelanggan Aktif: Pelanggan unik yang memesan dalam 30 hari terakhir (tidak dibatalkan)
        $pelangganAktif = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', '!=', Pesanan::STATUS_DIBATALKAN)
            ->where('updated_at', '>=', now()->subDays(30))
            ->distinct('ID_Akun')
            ->count('ID_Akun');

        $totalTransaksi = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
            ->count();

        // Pelanggan Baru: Pelanggan unik yang pertama kali memesan / memesan di bulan ini
        $pelangganBaru = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->distinct('ID_Akun')
            ->count('ID_Akun');

        // 2. Data Pelanggan (Paginated)
        $customersData = Pesanan::where('pesanan.ID_Toko', $toko->ID_Toko)
            ->join('informasi_akun', 'pesanan.ID_Akun', '=', 'informasi_akun.ID_Akun')
            ->select(
                'pesanan.ID_Akun',
                DB::raw('COALESCE(MAX(pesanan.nama_pembeli), MAX(informasi_akun.Username)) as name'),
                DB::raw('MAX(informasi_akun.Username) as username'),
                DB::raw('MAX(informasi_akun.Email) as email'),
                DB::raw('MAX(informasi_akun.Nomer_Telepon) as phone'),
                DB::raw('SUM(CASE WHEN pesanan.Status_Pesanan = "Selesai" THEN pesanan.total_harga ELSE 0 END) as total_spent'),
                DB::raw('COUNT(CASE WHEN pesanan.Status_Pesanan = "Selesai" THEN 1 END) as total_trx'),
                DB::raw('MAX(pesanan.updated_at) as last_transaction')
            )
            ->groupBy('pesanan.ID_Akun')
            ->orderBy('last_transaction', 'desc')
            ->paginate(10);

        // Fetch detailed order history for the paginated customers in this store
        $customerIds = $customersData->pluck('ID_Akun');
        $history = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->whereIn('ID_Akun', $customerIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('ID_Akun');

        // 3. Activity Timeline
        $activities = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($order) {
                $name = $order->nama_pembeli ?? $order->Username ?? 'Pelanggan';
                $product = $order->nama_produk ?? 'Pasir';
                $qty = $order->Unit ?? 0;
                $total = number_format($order->total_harga, 0, ',', '.');
                
                return match ($order->Status_Pesanan) {
                    Pesanan::STATUS_SELESAI => [
                        'icon' => 'task_alt',
                        'color' => 'bg-green-50 text-green-600',
                        'title' => "{$name} menyelesaikan pembelian",
                        'desc' => "{$product} ({$qty} unit) — Rp {$total}",
                        'time' => $order->updated_at->diffForHumans()
                    ],
                    Pesanan::STATUS_DIKIRIM => [
                        'icon' => 'local_shipping',
                        'color' => 'bg-blue-50 text-blue-600',
                        'title' => "Pesanan {$name} sedang dikirim",
                        'desc' => "{$product} ({$qty} unit)" . ($order->info_pengiriman ? " — {$order->info_pengiriman}" : ""),
                        'time' => $order->updated_at->diffForHumans()
                    ],
                    Pesanan::STATUS_PENDING => [
                        'icon' => 'shopping_bag',
                        'color' => 'bg-primary/10 text-primary',
                        'title' => "Pesanan baru dari {$name}",
                        'desc' => "{$product} ({$qty} unit) — Rp {$total}",
                        'time' => $order->created_at->diffForHumans()
                    ],
                    Pesanan::STATUS_DIPROSES => [
                        'icon' => 'manufacturing',
                        'color' => 'bg-purple-50 text-purple-600',
                        'title' => "Pesanan {$name} sedang diproses",
                        'desc' => "{$product} ({$qty} unit)",
                        'time' => $order->updated_at->diffForHumans()
                    ],
                    Pesanan::STATUS_DIBATALKAN => [
                        'icon' => 'cancel',
                        'color' => 'bg-red-50 text-red-500',
                        'title' => "Pesanan {$name} dibatalkan",
                        'desc' => "{$product} ({$qty} unit)" . ($order->alasan_tolak ? " — Alasan: {$order->alasan_tolak}" : ""),
                        'time' => $order->updated_at->diffForHumans()
                    ],
                    default => [
                        'icon' => 'info',
                        'color' => 'bg-surface-container text-on-surface-variant',
                        'title' => "Aktivitas pesanan {$name}",
                        'desc' => "{$product} ({$qty} unit) — Status: {$order->Status_Pesanan}",
                        'time' => $order->updated_at->diffForHumans()
                    ]
                };
            });

        // 4. Loyal Customers
        $loyalCustomers = Pesanan::where('ID_Toko', $toko->ID_Toko)
            ->where('Status_Pesanan', Pesanan::STATUS_SELESAI)
            ->select('ID_Akun', DB::raw('MAX(nama_pembeli) as name'), DB::raw('COUNT(*) as trx'))
            ->groupBy('ID_Akun')
            ->orderBy('trx', 'desc')
            ->take(3)
            ->get();

        $maxTrx = max(10, $loyalCustomers->max('trx'));

        return view('tampilanPenjualStore.MonitoringPelanggan', compact(
            'totalPelanggan',
            'pelangganAktif',
            'totalTransaksi',
            'pelangganBaru',
            'customersData',
            'history',
            'activities',
            'loyalCustomers',
            'maxTrx'
        ));
    }
}
