<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class MenuUtamaController extends Controller
{
    /**
     * Tampilkan halaman utama dengan daftar toko yang AKTIF saja.
     * Toko inactive tidak akan muncul di homepage maupun pencarian.
     */
    public function index()
    {
        $tokoList = Toko::active()->get();

        return view('tampilaUntukUser.MenuUtama', compact('tokoList'));
    }

    public function storeIndex()
    {
        $tokoList = Toko::active()->get();

        return view('tampilanPenjualStore.MenuUtamaStore', compact('tokoList'));
    }
}
