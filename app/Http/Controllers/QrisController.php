<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     */
    public function update(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();

        // Delete old image if exists
        if ($toko->Gambar_QRIS && Storage::disk('public')->exists($toko->Gambar_QRIS)) {
            Storage::disk('public')->delete($toko->Gambar_QRIS);
        }

        $path = $request->file('qris_image')->store('qris_images', 'public');

        $toko->update([
            'Gambar_QRIS' => $path
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
     */
    public function getQrisUrl($id)
    {
        $toko = Toko::findOrFail($id);

        if ($toko->Gambar_QRIS && Storage::disk('public')->exists($toko->Gambar_QRIS)) {
            return response()->json([
                'status' => 'success',
                'url' => asset('storage/' . $toko->Gambar_QRIS)
            ]);
        }

        return response()->json([
            'status' => 'not_found',
            'message' => 'QRIS belum tersedia'
        ]);
    }
}
