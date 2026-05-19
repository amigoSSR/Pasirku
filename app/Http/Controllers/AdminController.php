<?php

namespace App\Http\Controllers;

use App\Events\StoreStatusChanged;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_toko'     => \App\Models\Toko::count(),
            'toko_aktif'     => \App\Models\Toko::where('Status', 'active')->count(),
            'toko_inactive'  => \App\Models\Toko::where('Status', 'inactive')->count(),
            'total_users'    => \App\Models\User::where('Role', 'user')->count(),
            'total_pendapatan' => \App\Models\Toko::sum('Pendapatan_Toko'),
            'total_komisi'   => \App\Models\Toko::sum('Komisi_Admin'),
            'total_pembelian'=> \App\Models\Toko::sum('Total_Pembelian'),
        ];

        $recentToko = \App\Models\Toko::latest()->take(5)->get();

        return view('tampilanUntukAdmin.MenuUtamaAdmin', compact('stats', 'recentToko'));
    }

    /**
     * Halaman daftar toko — admin melihat SEMUA toko (aktif & inactive).
     */
    public function shopeRegistry()
    {
        $tokoList = Toko::all();
        return view('tampilanUntukAdmin.ShopeRegistry', compact('tokoList'));
    }

    public function profile()
    {
        return view('tampilanUntukAdmin.profilAdmin');
    }

    public function toggleStatus(Request $request, $id)
    {
        if (Auth::user()->Role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $toko = Toko::findOrFail($id);

        $newStatus = $toko->Status === 'active' ? 'inactive' : 'active';
        $toko->update(['Status' => $newStatus]);

        // Dispatch event to update user role (listener protects admin accounts)
        event(new StoreStatusChanged($id, $newStatus, $toko->ID_Akun));

        return back()->with('success', 'Status toko berhasil diubah menjadi ' . ucfirst($newStatus) . '.');
    }
}