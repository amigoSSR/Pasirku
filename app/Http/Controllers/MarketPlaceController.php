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
        $toko = Toko::active()->with(['reviews.akun'])->where('ID_Toko', $id)->firstOrFail();

        $isiToko = DB::table('isi_toko')->where('ID_Toko', $id)->get();

        // Statistics
        $averageRating = $toko->averageRating();
        $totalReviews = $toko->reviews()->count();
        $ratingDistribution = $toko->ratingDistribution();
        $totalBuyers = DB::table('pesanan')->where('ID_Toko', $id)->where('Status_Pesanan', 'Selesai')->distinct('ID_Akun')->count();
        
        // Recent reviews
        $recentReviews = $toko->reviews()->with('akun')->latest()->take(5)->get();

        return view('tampilaUntukUser.MarketPlace', compact(
            'toko', 
            'isiToko', 
            'averageRating', 
            'totalReviews', 
            'ratingDistribution', 
            'totalBuyers',
            'recentReviews'
        ));
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
