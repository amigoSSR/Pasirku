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

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,store,admin,cs'
        ]);

        DB::table('informasi_akun')
            ->where('ID_Akun', $id)
            ->update(['Role' => $request->role]);

        return back()->with('success', 'Role pengguna berhasil diperbarui.');
    }
}