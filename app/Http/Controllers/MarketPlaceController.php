<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketPlaceController extends Controller
{
    public function show($id)
    {
        $toko = DB::table('informasi_toko')->where('ID_Toko', $id)->firstOrFail();
        $isiToko = DB::table('isi_toko')->where('ID_Toko', $id)->get();

        return view('MarketPlace', compact('toko', 'isiToko'));
    }
}
