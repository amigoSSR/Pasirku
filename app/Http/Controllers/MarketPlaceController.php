<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketPlaceController extends Controller
{
    /**
     * Tampilkan halaman marketplace sebuah toko.
     * Hanya toko aktif yang bisa diakses — akses langsung via URL ke toko
     * inactive akan mendapat 404 (bukan 403) agar tidak membocorkan info.
     */
    public function show($id)
    {
        // scopeActive() memastikan hanya toko dengan Status='active' yang ditemukan.
        // Jika inactive atau tidak ada → 404.
        $toko = Toko::active()->where('ID_Toko', $id)->firstOrFail();

        $isiToko = DB::table('isi_toko')->where('ID_Toko', $id)->get();

        return view('tampilaUntukUser.MarketPlace', compact('toko', 'isiToko'));
    }
}
