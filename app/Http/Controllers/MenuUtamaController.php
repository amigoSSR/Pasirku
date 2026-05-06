<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuUtamaController extends Controller
{
    public function index()
    {
        $tokoList = DB::table('informasi_toko')->get();

        return view('MenuUtama', compact('tokoList'));
    }
}
