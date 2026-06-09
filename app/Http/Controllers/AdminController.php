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
            'total_toko'       => \App\Models\Toko::count(),
            'toko_aktif'       => \App\Models\Toko::where('Status', 'approved')->count(),
            'toko_pending'     => \App\Models\Toko::where('Status', 'pending')->count(),
            'toko_rejected'    => \App\Models\Toko::where('Status', 'rejected')->count(),
            'total_users'      => \App\Models\User::where('Role', 'user')->count(),
            'total_pendapatan' => \App\Models\Toko::sum('Pendapatan_Toko'),
            'total_komisi'     => \App\Models\Toko::sum('Komisi_Admin'),
            'total_pembelian'  => \App\Models\Toko::sum('Total_Pembelian'),
        ];

        $recentToko = \App\Models\Toko::latest()->take(5)->get();

        return view('tampilanUntukAdmin.MenuUtamaAdmin', compact('stats', 'recentToko'));
    }

    /**
     * Halaman daftar toko — admin melihat SEMUA toko (aktif & inactive).
     */
    public function shopeRegistry()
    {
        $tokoList = Toko::latest()->paginate(2);

        $stats = [
            'total'    => Toko::count(),
            'approved' => Toko::where('Status', 'approved')->count(),
            'pending'  => Toko::where('Status', 'pending')->count(),
            'komisi'   => Toko::sum('Komisi_Admin'),
        ];

        return view('tampilanUntukAdmin.ShopeRegistry', compact('tokoList', 'stats'));
    }

    /**
     * Fitur Pantau Toko (Query Toko)
     * Admin bisa memilih toko dan melihat daftar pembelian di toko tersebut.
     */
    public function queryToko(Request $request)
    {
        $tokoList = Toko::orderBy('Nama_Toko')->get();
        $selectedToko = null;
        $orders = collect();
        $stats = null;

        if ($request->has('toko_id')) {
            $selectedToko = Toko::findOrFail($request->toko_id);
            $orders = \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            $stats = [
                'total_orders' => \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)->count(),
                'total_revenue' => \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)
                    ->where('Status_Pesanan', \App\Models\Pesanan::STATUS_SELESAI)
                    ->sum('total_harga'),
                'total_units' => \App\Models\Pesanan::where('ID_Toko', $selectedToko->ID_Toko)
                    ->where('Status_Pesanan', \App\Models\Pesanan::STATUS_SELESAI)
                    ->sum('Unit'),
            ];
        }

        return view('tampilanUntukAdmin.QueryToko', compact('tokoList', 'selectedToko', 'orders', 'stats'));
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

        if ($request->has('status')) {
            $newStatus = $request->input('status');
        } else {
            $newStatus = $toko->Status === 'approved' ? 'rejected' : 'approved';
        }

        if (!in_array($newStatus, ['pending', 'approved', 'rejected'])) {
            return back()->with('error', 'Status pendaftaran toko tidak valid.');
        }

        $toko->update(['Status' => $newStatus]);

        // Dispatch event to update user role (listener protects admin accounts)
        event(new StoreStatusChanged($id, $newStatus, $toko->ID_Akun));

        return back()->with('success', 'Status toko berhasil diubah menjadi ' . ucfirst($newStatus) . '.');
    }

    /**
     * Memperbarui alamat & koordinat peta suatu toko oleh admin.
     */
    public function updateLocation(Request $request, $id)
    {
        if (Auth::user()->Role !== 'admin') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $toko = Toko::findOrFail($id);

        $request->validate([
            'provinsi'      => 'required|string|max:255',
            'kota'          => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'detail_alamat' => 'required|string',
            'kode_pos'      => 'required|string|max:10',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
        ]);

        $lokasiLengkap = sprintf(
            '%s, Kec. %s, %s, %s, %s',
            $request->detail_alamat,
            $request->kecamatan,
            $request->kota,
            $request->provinsi,
            $request->kode_pos
        );

        $toko->update([
            'provinsi'      => $request->provinsi,
            'kota'          => $request->kota,
            'kecamatan'     => $request->kecamatan,
            'detail_alamat' => $request->detail_alamat,
            'kode_pos'      => $request->kode_pos,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'Lokasi_Toko'   => $lokasiLengkap,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lokasi toko ' . $toko->Nama_Toko . ' berhasil diperbarui!',
                'toko' => $toko
            ]);
        }

        return back()->with('success', 'Lokasi toko ' . $toko->Nama_Toko . ' berhasil diperbarui!');
    }
}