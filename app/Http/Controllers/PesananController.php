<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PesananController extends Controller
{
    /**
     * Simpan pesanan baru + bukti pembayaran.
     * Dipanggil saat user menekan "KONFIRMASI PESANAN".
     */
    public function store(Request $request)
    {
        // ── 1. Validasi ──────────────────────────────────────────────
        $request->validate([
            'bukti_pembayaran'   => 'required|image|mimes:jpeg,jpg,png,webp,bmp,gif|max:5120',
            'id_toko'            => 'required|integer',
            'lokasi_pengantaran' => 'required|string|max:500',
            'detail_lokasi'      => 'nullable|string|max:500',
            'unit'               => 'required|integer|min:1',
            'tanggal_pengiriman' => 'required|date',
            'jam_tiba'           => 'required|string|max:100',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image'    => 'File harus berupa gambar.',
            'bukti_pembayaran.max'      => 'Ukuran gambar maksimal 5 MB.',
            'lokasi_pengantaran.required' => 'Lokasi pengantaran wajib diisi.',
            'unit.required'              => 'Jumlah unit wajib diisi.',
            'tanggal_pengiriman.required' => 'Tanggal pengiriman wajib diisi.',
            'jam_tiba.required'          => 'Estimasi jam tiba wajib diisi.',
        ]);

        // ── 2. Konversi gambar → PNG ──────────────────────────────────
        $file    = $request->file('bukti_pembayaran');
        $tmpPath = $file->getRealPath();
        $mime    = $file->getMimeType();

        // Buat resource GD dari berbagai format sumber
        $source = match (true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($tmpPath),
            str_contains($mime, 'png')  => imagecreatefrompng($tmpPath),
            str_contains($mime, 'webp') => imagecreatefromwebp($tmpPath),
            str_contains($mime, 'gif')  => imagecreatefromgif($tmpPath),
            str_contains($mime, 'bmp')  => imagecreatefrombmp($tmpPath),
            default                     => imagecreatefromjpeg($tmpPath),
        };

        // ── 3. Buat nama file terformat ───────────────────────────────
        // Format: (dd-mm-yyyy)_(BP+6char)_(8char).png
        $tanggal     = now()->format('d-m-Y');
        $kodeBukti   = 'BP' . strtoupper(Str::random(6));   // mis. BPAB3C4D
        $kodeUnik    = strtoupper(Str::random(8));           // mis. E5F6G7H8
        $namaFile    = "{$tanggal}_{$kodeBukti}_{$kodeUnik}.png";

        // ── 4. Simpan PNG ke storage ──────────────────────────────────
        $folder  = 'bukti_pembayaran';
        $diskPath = storage_path("app/public/{$folder}");
        if (! is_dir($diskPath)) {
            mkdir($diskPath, 0755, true);
        }

        $fullPath = "{$diskPath}/{$namaFile}";
        imagepng($source, $fullPath, 6);   // kualitas kompresi 6/9
        imagedestroy($source);

        // Path relatif untuk DB dan URL
        $storagePath = "{$folder}/{$namaFile}";  // bukti_pembayaran/xxx.png

        // ── 5. Ambil info toko dan isi toko ───────────────────────────
        $toko = DB::table('informasi_toko')->where('ID_Toko', $request->id_toko)->first();
        if (! $toko) {
            return back()->withErrors(['id_toko' => 'Toko tidak ditemukan.']);
        }

        // Ambil Harga_PickUp & Harga_Truck dari tabel isi_toko untuk toko ini
        $produkToko = DB::table('isi_toko')->where('ID_Toko', $toko->ID_Toko)->first();
        $hargaPickUp = $produkToko ? (int) $produkToko->Harga_PickUp : 0;
        $hargaTruck  = $produkToko ? (int) $produkToko->Harga_Truck : 0;

        $user = Auth::user();
        
        $Detail_Lokasi = $request->detail_lokasi;
        $lokasiPengantaranFinal = $Detail_Lokasi ? $request->lokasi_pengantaran . ' | ' . $Detail_Lokasi : $request->lokasi_pengantaran;

        // ── 6. Simpan pesanan ke database ─────────────────────────────
        DB::table('pesanan')->insert([
            'ID_Akun'            => $user->ID_Akun,
            'ID_Toko'            => $toko->ID_Toko,
            'Username'           => $user->Username,
            'Nama_Toko'          => $toko->Nama_Toko,
            'Lokasi_Toko'        => $toko->Lokasi_Toko,
            'Lokasi_Pengantaran' => $lokasiPengantaranFinal,
            'Harga_PickUp'       => $hargaPickUp,
            'Harga_Truck'        => $hargaTruck,
            'Unit'               => (int) $request->unit,
            'Ongkir_PickUp'      => (int) ($toko->Ongkir_PickUp ?? 0),
            'Ongkir_Truck'       => (int) ($toko->Ongkir_Truck ?? 0),
            'Status_Pembayaran'  => 'Belum Dikonfirmasi',
            'Status_Pesanan'     => 'Belum Diterima Toko',
            'Bukti_Pembayaran'   => $storagePath,
            'Tanggal_Pengiriman' => $request->tanggal_pengiriman,
            'Jam_Tiba'           => $request->jam_tiba,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // ── 7. Bersihkan sessionStorage keranjang via flash ───────────
        session()->flash('clear_cart', true);

        return redirect()->route('ordertracking')
                         ->with('success', 'Pesanan kamu akan di cek oleh Toko');
    }

    /**
     * Serve file gambar bukti pembayaran dengan HTTP Cache Headers.
     * Ini mencegah server memuat ulang gambar yang sama (efisien saat deploy).
     */
    public function serveImage(string $filename)
    {
        $path = storage_path("app/public/bukti_pembayaran/{$filename}");

        if (! file_exists($path)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $mtime    = filemtime($path);
        $etag     = md5_file($path);
        $lastMod  = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';

        // Cek browser cache (304 Not Modified)
        $ifNoneMatch  = request()->header('If-None-Match');
        $ifModSince   = request()->header('If-Modified-Since');

        if ($ifNoneMatch === $etag || $ifModSince === $lastMod) {
            return response('', 304);
        }

        return response()->file($path, [
            'Content-Type'  => 'image/png',
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'ETag'          => $etag,
            'Last-Modified' => $lastMod,
        ]);
    }
}
