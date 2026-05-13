<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('tampilanUntukAdmin.MenuUtamaAdmin');
    }

    public function shopeRegistry()
    {
        $tokoList = \Illuminate\Support\Facades\DB::table('informasi_toko')->get();
        return view('tampilanUntukAdmin.ShopeRegistry', compact('tokoList'));
    }

    public function profile()
    {
        return view('tampilanUntukAdmin.profilAdmin');
    }

    public function toggleStatus(Request $request, $id)
    {
        if (\Illuminate\Support\Facades\Auth::user()->Role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $toko = \Illuminate\Support\Facades\DB::table('informasi_toko')->where('ID_Toko', $id)->first();
        if (!$toko) return back()->with('error', 'Toko tidak ditemukan.');

        $newStatus = $toko->Status === 'active' ? 'inactive' : 'active';
        \Illuminate\Support\Facades\DB::table('informasi_toko')->where('ID_Toko', $id)->update(['Status' => $newStatus]);

        return back()->with('success', "Status toko berhasil diubah menjadi " . ucfirst($newStatus) . ".");
    }
}