<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreProfileController extends Controller
{
    /**
     * Tampilkan halaman profil toko dengan map.
     */
    public function showProfile()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki akses toko.');
        }

        return view('tampilanPenjualStore.profilStore', compact('toko'));
    }

    /**
     * Tampilkan halaman pengaturan toko.
     */
    public function showSettings()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki akses toko.');
        }

        return view('tampilanPenjualStore.settings', compact('toko'));
    }

    /**
     * Update data alamat & koordinat peta toko.
     */
    public function updateAddress(Request $request)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'provinsi'      => 'required|string|max:255',
            'kota'          => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'detail_alamat' => 'required|string',
            'kode_pos'      => 'required|string|max:10',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
        ]);

        // Concatenate address for backwards compatibility
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
            'Lokasi_Toko'   => $lokasiLengkap, // sync the existing string field
        ]);

        return redirect()->back()->with('success', 'Alamat & lokasi toko berhasil diperbarui!');
    }

    /**
     * Update informasi umum toko (Nama, Telepon, Email).
     */
    public function updateGeneralInfo(Request $request)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'Nama_Toko'          => 'required|string|max:255',
            'Nomer_Telepon_Toko' => 'required|string|max:20',
            'Email_Toko'         => 'required|email|max:255',
        ]);

        $toko->update($request->only(['Nama_Toko', 'Nomer_Telepon_Toko', 'Email_Toko']));

        return redirect()->back()->with('success', 'Informasi dasar toko berhasil diperbarui!');
    }

    /**
     * Update foto profil toko.
     */
    public function updatePhoto(Request $request)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'foto_toko' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto_toko')) {
            // Hapus foto lama jika ada
            if ($toko->Foto_Toko) {
                Storage::disk('public')->delete($toko->Foto_Toko);
            }

            $path = $request->file('foto_toko')->store('store_photos', 'public');
            $toko->update(['Foto_Toko' => $path]);

            return redirect()->back()->with('success', 'Foto toko berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }
}
