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
        return view('tampilanUntukAdmin.MenuUtamaAdmin');
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