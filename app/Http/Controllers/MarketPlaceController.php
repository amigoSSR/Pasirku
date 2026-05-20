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

    /**
     * Check real-time stock for products in cart.
     */
    public function checkStock(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        $ids = array_map('intval', $request->ids);

        $stocks = DB::table('isi_toko')
            ->whereIn('ID_Isi_Toko', $ids)
            ->select('ID_Isi_Toko', 'Stock_PickUp', 'Stock_Truck', 'Status_Produk')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $stocks
        ]);
    }
}
