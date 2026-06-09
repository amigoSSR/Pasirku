<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;
use App\Models\User;
use App\Models\PembayaranKomisi;

class KomisiController extends Controller
{
    /**
     * Halaman Bayar Komisi untuk Toko
     */
    public function index()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();
        
        $admin = User::where('Role', 'admin')->first();
        $qrisAdmin = $admin ? $admin->qris_admin : null;

        $riwayat = PembayaranKomisi::where('ID_Toko', $toko->ID_Toko)->latest()->get();

        // Check pending payment
        $pendingPayment = PembayaranKomisi::where('ID_Toko', $toko->ID_Toko)->where('status', 'pending')->first();

        return view('tampilanPenjualStore.bayarKomisi', compact('toko', 'qrisAdmin', 'riwayat', 'pendingPayment'));
    }

    /**
     * Store upload bukti pembayaran komisi
     */
    public function store(Request $request)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($toko->Komisi_Admin <= 0) {
            return back()->with('error', 'Anda tidak memiliki tagihan komisi.');
        }

        $pending = PembayaranKomisi::where('ID_Toko', $toko->ID_Toko)->where('status', 'pending')->exists();
        if ($pending) {
            return back()->with('error', 'Anda masih memiliki pembayaran yang menunggu konfirmasi.');
        }

        // Konversi ke WebP
        $file    = $request->file('bukti_pembayaran');
        $tmpPath = $file->getRealPath();
        $mime    = $file->getMimeType();

        $source = match (true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($tmpPath),
            str_contains($mime, 'png')  => imagecreatefrompng($tmpPath),
            str_contains($mime, 'webp') => imagecreatefromwebp($tmpPath),
            default                     => imagecreatefromjpeg($tmpPath),
        };

        $namaFile = 'komisi_' . date('d-m-Y') . '_' . $toko->ID_Toko . '_' . uniqid() . '.webp';
        $diskPath = storage_path('app/public/bukti_komisi');
        if (!is_dir($diskPath)) {
            mkdir($diskPath, 0755, true);
        }

        $fullPath = "{$diskPath}/{$namaFile}";
        imagewebp($source, $fullPath, 80);
        imagedestroy($source);

        PembayaranKomisi::create([
            'ID_Toko' => $toko->ID_Toko,
            'jumlah_komisi' => $toko->Komisi_Admin,
            'bukti_pembayaran' => "bukti_komisi/{$namaFile}",
            'status' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload dan menunggu konfirmasi admin.');
    }
}
