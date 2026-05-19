<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * User's Order Tracking Page
     */
    public function userOrders()
    {
        $orders = Pesanan::where('ID_Akun', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tampilaUntukUser.ordertracking', compact('orders'));
    }

    /**
     * Store's Order Management Page
     */
    public function storeOrders()
    {
        // Pastikan hanya store yang bisa akses dan ambil pesanan milik tokonya
        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403, 'Anda tidak memiliki toko.');
        }

        $query = Pesanan::where('ID_Toko', $toko->ID_Toko);

        if (request()->has('status') && request()->status !== 'Semua') {
            $status = request()->status;
            // Map simple filter labels to actual statuses
            $statusMap = [
                'Baru' => Pesanan::STATUS_PENDING,
                'Proses' => Pesanan::STATUS_DIPROSES,
                'Kirim' => Pesanan::STATUS_DIKIRIM,
                'Selesai' => Pesanan::STATUS_SELESAI,
            ];
            
            if (isset($statusMap[$status])) {
                $query->where('Status_Pesanan', $statusMap[$status]);
            }
        }

        if (request()->has('search') && !empty(request()->search)) {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('ID_Pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_pembeli', 'like', "%{$search}%")
                  ->orWhere('nama_produk', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        $statuses = [
            'total' => Pesanan::where('ID_Toko', $toko->ID_Toko)->count(),
            'pending' => Pesanan::where('ID_Toko', $toko->ID_Toko)->where('Status_Pesanan', Pesanan::STATUS_PENDING)->count(),
            'dikirim' => Pesanan::where('ID_Toko', $toko->ID_Toko)->where('Status_Pesanan', Pesanan::STATUS_DIKIRIM)->count(),
            'selesai_hari_ini' => Pesanan::where('ID_Toko', $toko->ID_Toko)->where('Status_Pesanan', Pesanan::STATUS_SELESAI)->whereDate('updated_at', today())->count(),
        ];

        return view('tampilanPenjualStore.ordertrackingStore', compact('orders', 'statuses'));
    }

    /**
     * Update Order Status (Store action)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,diproses,dikirim,selesai,dibatalkan',
            'alasan_tolak' => 'nullable|string',
            'info_pengiriman' => 'nullable|string',
        ]);

        $toko = Toko::where('ID_Akun', Auth::id())->first();
        if (!$toko) {
            abort(403);
        }

        $pesanan = Pesanan::where('ID_Toko', $toko->ID_Toko)->findOrFail($id);
        
        $pesanan->Status_Pesanan = $request->status;
        
        if ($request->status === Pesanan::STATUS_DIBATALKAN && $request->filled('alasan_tolak')) {
            $pesanan->alasan_tolak = $request->alasan_tolak;
        }

        if ($request->status === Pesanan::STATUS_DIKIRIM && $request->filled('info_pengiriman')) {
            $pesanan->info_pengiriman = $request->info_pengiriman;
        }

        $pesanan->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
