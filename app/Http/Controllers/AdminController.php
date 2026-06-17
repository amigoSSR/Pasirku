<?php

namespace App\Http\Controllers;

use App\Events\StoreStatusChanged;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_toko'       => \App\Models\Toko::count(),
            'toko_aktif'       => \App\Models\Toko::where('Status', 'approved')->count(),
            'toko_pending'     => \App\Models\Toko::where('Status', 'pending')->count(),
            'toko_rejected'    => \App\Models\Toko::where('Status', 'rejected')->count(),
            'total_users'      => \App\Models\User::where('Role', 'user')->count(),
            'total_pendapatan' => \App\Models\Toko::sum('Pendapatan_Toko'),
            'total_komisi'     => \App\Models\Toko::sum('Komisi_Admin'),
            'total_pembelian'  => \App\Models\Toko::sum('Total_Pembelian'),
            'komisi_bulan_ini' => \App\Models\Pesanan::whereMonth('created_at', now()->month)
                                     ->whereYear('created_at', now()->year)
                                     ->sum('komisi_admin'),
            'total_komisi_historis' => \App\Models\PembayaranKomisi::where('status', 'confirmed')->sum('jumlah_komisi'),
        ];

        $recentToko = \App\Models\Toko::latest()->take(5)->get();

        return view('tampilanUntukAdmin.MenuUtamaAdmin', compact('stats', 'recentToko'));
    }

    /**
     * Halaman daftar toko — admin melihat SEMUA toko (aktif & inactive).
     */
    public function shopeRegistry()
    {
        $tokoList = Toko::latest()->paginate(2);

        $stats = [
            'total'    => Toko::count(),
            'approved' => Toko::where('Status', 'approved')->count(),
            'pending'  => Toko::where('Status', 'pending')->count(),
            'komisi'   => Toko::sum('Komisi_Admin'),
        ];

        return view('tampilanUntukAdmin.ShopeRegistry', compact('tokoList', 'stats'));
    }

    /**
     * Fitur Pantau Toko (Query Toko)
     * Admin bisa memilih toko dan melihat daftar pembelian di toko tersebut.
     */
    public function queryToko(Request $request)
    {
        $tokoList = Toko::orderBy('Nama_Toko')->get();
        $selectedToko = null;
        $orders = collect();
        $stats = null;

        if ($request->has('toko_id')) {
            $selectedToko = Toko::findOrFail($request->toko_id);
            $orders = \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            $stats = [
                'total_orders' => \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)->count(),
                'total_revenue' => \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)
                    ->where('Status_Pesanan', \App\Models\Pesanan::STATUS_SELESAI)
                    ->sum('total_harga'),
                'total_units' => \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)
                    ->where('Status_Pesanan', \App\Models\Pesanan::STATUS_SELESAI)
                    ->sum('Unit'),
            ];
        }

        return view('tampilanUntukAdmin.QueryToko', compact('tokoList', 'selectedToko', 'orders', 'stats'));
    }

    public function profile()
    {
        return view('tampilanUntukAdmin.profilAdmin');
    }

    public function settings()
    {
        return view('tampilanUntukAdmin.settings');
    }

    public function toggleStatus(Request $request, $id)
    {
        if (Auth::user()->Role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $toko = Toko::findOrFail($id);

        if ($request->has('status')) {
            $newStatus = $request->input('status');
        } else {
            $newStatus = $toko->Status === 'approved' ? 'rejected' : 'approved';
        }

        if (!in_array($newStatus, ['pending', 'approved', 'rejected', 'expired'])) {
            return back()->with('error', 'Status pendaftaran toko tidak valid.');
        }

        // Jika diapprove kembali (misal dari expired/rejected), kita bisa reset aktif_sampai jika masih null atau expired
        // Tapi kita percayakan pada logika First Revenue. Jadi biarkan saja.
        $toko->update(['Status' => $newStatus]);

        // Dispatch event to update user role (listener protects admin accounts)
        event(new StoreStatusChanged($id, $newStatus, $toko->ID_Akun));

        return back()->with('success', 'Status toko berhasil diubah menjadi ' . ucfirst($newStatus) . '.');
    }

    /**
     * Memperbarui alamat & koordinat peta suatu toko oleh admin.
     */
    public function updateLocation(Request $request, $id)
    {
        if (Auth::user()->Role !== 'admin') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $toko = Toko::findOrFail($id);

        $request->validate([
            'provinsi'      => 'required|string|max:255',
            'kota'          => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'detail_alamat' => 'required|string',
            'kode_pos'      => 'required|string|max:10',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
        ]);

        $lokasiLengkap = sprintf(
            '%s, Kec. %s, %s, %s, %s',
            $request->detail_alamat,
            $request->kecamatan,
            $request->kota,
            $request->provinsi,
            $request->kode_pos
        );

        $toko->update([
            'provinsi'      => $request->provinsi,
            'kota'          => $request->kota,
            'kecamatan'     => $request->kecamatan,
            'detail_alamat' => $request->detail_alamat,
            'kode_pos'      => $request->kode_pos,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'Lokasi_Toko'   => $lokasiLengkap,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lokasi toko ' . $toko->Nama_Toko . ' berhasil diperbarui!',
                'toko' => $toko
            ]);
        }

        return back()->with('success', 'Lokasi toko ' . $toko->Nama_Toko . ' berhasil diperbarui!');
    }

    /**
     * Upload QRIS Admin untuk pembayaran komisi.
     */
    public function uploadAdminQris(Request $request)
    {
        $request->validate([
            'qris_admin' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $currentAdmin = Auth::user();
        $oldQris = $currentAdmin->qris_admin;

        // Konversi ke WebP
        $file    = $request->file('qris_admin');
        $tmpPath = $file->getRealPath();
        $mime    = $file->getMimeType();

        $source = match (true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($tmpPath),
            str_contains($mime, 'png')  => imagecreatefrompng($tmpPath),
            str_contains($mime, 'webp') => imagecreatefromwebp($tmpPath),
            default                     => imagecreatefromjpeg($tmpPath),
        };

        $namaFile = 'admin_qris_' . time() . '.webp';
        $diskPath = storage_path('app/public/admin_settings');
        if (!is_dir($diskPath)) {
            mkdir($diskPath, 0755, true);
        }

        $fullPath = "{$diskPath}/{$namaFile}";
        imagewebp($source, $fullPath, 80);
        imagedestroy($source);

        $newPath = "admin_settings/{$namaFile}";

        // Update SEMUA admin agar QRIS seragam sebagai settingan platform
        \App\Models\User::where('Role', 'admin')->update([
            'qris_admin' => $newPath
        ]);

        // Hapus file lama jika ada
        if ($oldQris && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldQris)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldQris);
        }

        return back()->with('success', 'QRIS Admin berhasil diperbarui untuk seluruh sistem.');
    }

    /**
     * Hapus QRIS Admin.
     */
    public function deleteAdminQris()
    {
        $currentAdmin = Auth::user();
        $oldQris = $currentAdmin->qris_admin;

        // Update SEMUA admin agar QRIS dihapus seragam sebagai settingan platform
        \App\Models\User::where('Role', 'admin')->update([
            'qris_admin' => null
        ]);

        // Hapus file lama jika ada
        if ($oldQris && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldQris)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldQris);
        }

        return back()->with('success', 'QRIS Admin berhasil dihapus.');
    }

    /**
     * Halaman manajemen komisi.
     */
    public function komisiPayments()
    {
        $payments = \App\Models\PembayaranKomisi::with('toko')->latest()->paginate(10);
        
        $nearExpiryStores = \App\Models\Toko::whereNotNull('aktif_sampai')
            ->whereDate('aktif_sampai', '<=', now()->addDays(7))
            ->orderBy('aktif_sampai', 'asc')
            ->get();

        return view('tampilanUntukAdmin.konfirmasiKomisi', compact('payments', 'nearExpiryStores'));
    }

    /**
     * Konfirmasi pembayaran komisi toko.
     */
    public function confirmKomisi($id)
    {
        $payment = \App\Models\PembayaranKomisi::findOrFail($id);
        
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diproses.');
        }

        DB::transaction(function() use ($payment) {
            $payment->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            $toko = $payment->toko;
            
            // Kurangi komisi toko sesuai nominal yang dibayar, jangan reset ke 0
            $toko->Komisi_Admin = max(0, $toko->Komisi_Admin - $payment->jumlah_komisi);
            
            // Perpanjang masa aktif 1 bulan
            if ($toko->aktif_sampai) {
                // Jika sudah expired, tambah dari hari ini. Jika belum, tambah dari masa aktif sebelumnya.
                $baseDate = \Carbon\Carbon::parse($toko->aktif_sampai)->isPast() ? now() : \Carbon\Carbon::parse($toko->aktif_sampai);
                $newDate = $baseDate->addMonth();
            } else {
                $newDate = now()->addMonth();
            }

            // Batasi maksimal masa aktif adalah 3 bulan dari hari ini
            $maxDate = now()->addMonths(3);
            if ($newDate->greaterThan($maxDate)) {
                $newDate = $maxDate;
            }

            $toko->aktif_sampai = $newDate->toDateString();
            $toko->save();
            
            // Jika status toko expired, aktifkan kembali
            if ($toko->Status === 'expired') {
                $toko->Status = 'approved';
                event(new StoreStatusChanged($toko->ID_Toko, 'approved', $toko->ID_Akun));
            }
            $toko->save();
        });

        return back()->with('success', 'Pembayaran komisi berhasil dikonfirmasi. Komisi toko direset dan masa aktif diperpanjang 1 bulan.');
    }

    /**
     * Tolak pembayaran komisi.
     */
    public function rejectKomisi($id)
    {
        $payment = \App\Models\PembayaranKomisi::findOrFail($id);
        
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diproses.');
        }

        $payment->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Pembayaran komisi ditolak.');
    }
}