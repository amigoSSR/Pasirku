<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QrisController extends Controller
{
    /**
     * Show the QRIS management view for the Store.
     */
    public function index()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki toko.');
        }

        return view('tampilanPenjualStore.qrisStore', compact('toko'));
    }

    /**
     * Handle the upload of the QRIS image.
     * Converts to WebP format and uses formatted filename.
     */
    public function update(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();

        // Delete old image if exists
        if ($toko->Gambar_QRIS && Storage::disk('public')->exists($toko->Gambar_QRIS)) {
            Storage::disk('public')->delete($toko->Gambar_QRIS);
        }

        // ── Konversi gambar ke WebP ──────────────────────────────────
        $file    = $request->file('qris_image');
        $tmpPath = $file->getRealPath();
        $mime    = $file->getMimeType();

        // Buat resource GD dari berbagai format sumber
        $source = match (true) {
            str_contains($mime, 'jpeg') => imagecreatefromjpeg($tmpPath),
            str_contains($mime, 'png')  => imagecreatefrompng($tmpPath),
            str_contains($mime, 'webp') => imagecreatefromwebp($tmpPath),
            default                     => imagecreatefromjpeg($tmpPath),
        };

        // ── Buat nama file terformat ─────────────────────────────────
        // Format: (dd-mm-yyyy)_(QRIS+6char)_(8char).webp
        $tanggal   = now()->format('d-m-Y');
        $kodeQris  = 'QRIS' . strtoupper(Str::random(6));   // mis. QRISA1B2C3
        $kodeUnik  = strtoupper(Str::random(8));             // mis. D4E5F6G7
        $namaFile  = "{$tanggal}_{$kodeQris}_{$kodeUnik}.webp";

        // ── Simpan WebP ke storage ───────────────────────────────────
        $folder   = 'qris_images';
        $diskPath = storage_path("app/public/{$folder}");
        if (!is_dir($diskPath)) {
            mkdir($diskPath, 0755, true);
        }

        $fullPath = "{$diskPath}/{$namaFile}";
        imagewebp($source, $fullPath, 80);  // kualitas 80
        imagedestroy($source);

        // Path relatif untuk DB
        $storagePath = "{$folder}/{$namaFile}";

        $toko->update([
            'Gambar_QRIS' => $storagePath
        ]);

        return back()->with('success', 'Gambar QRIS berhasil diunggah.');
    }

    /**
     * Handle the deletion of the QRIS image.
     */
    public function destroy()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();

        if ($toko->Gambar_QRIS && Storage::disk('public')->exists($toko->Gambar_QRIS)) {
            Storage::disk('public')->delete($toko->Gambar_QRIS);
        }

        $toko->update([
            'Gambar_QRIS' => null
        ]);

        return back()->with('success', 'Gambar QRIS berhasil dihapus.');
    }

    /**
     * API to fetch the store's QRIS image URL for the checkout page.
     * Serves the image directly with 1-year cache headers.
     */
    public function getQrisUrl($id)
    {
        $toko = Toko::findOrFail($id);

        if ($toko->Gambar_QRIS && Storage::disk('public')->exists($toko->Gambar_QRIS)) {
            $path = storage_path('app/public/' . $toko->Gambar_QRIS);

            return response()->json([
                'status' => 'success',
                'url' => asset('storage/' . $toko->Gambar_QRIS),
                'cache_headers' => [
                    'Cache-Control' => 'public, max-age=31536000, immutable',
                ]
            ])->header('Cache-Control', 'public, max-age=31536000, immutable');
        }

        return response()->json([
            'status' => 'not_found',
            'message' => 'QRIS belum tersedia'
        ]);
    }
}
