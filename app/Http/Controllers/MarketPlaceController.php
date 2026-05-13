<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketPlaceController extends Controller
{
    public function show($id)
    {
        $toko = DB::table('informasi_toko')->where('ID_Toko', $id)->first();
        if (!$toko) abort(404);
        
        if ($toko->Status !== 'active') {
            abort(403, 'Toko ini sedang dinonaktifkan oleh Admin.');
        }

        $isiToko = DB::table('isi_toko')->where('ID_Toko', $id)->get();

        return view('MarketPlace', compact('toko', 'isiToko'));
    }
}
