<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoopeRegistryController extends Controller
{
    public function index()
    {
        // Ambil data user dari database
        $users = DB::table('informasi_akun')->get();

        return view('admin.user-registry', compact('users'));
    }
}