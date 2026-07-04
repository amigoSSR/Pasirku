<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_toko' => 'required|exists:informasi_toko,ID_Toko',
            'items' => 'required|string', // JSON string of cart items
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'detail_lokasi' => 'required|string',
            'jadwal_pengiriman' => 'required|date',
        ]);

        $toko = Toko::findOrFail($request->id_toko);
        $items = json_decode($request->items, true);

        if (!$items || !is_array($items) || count($items) === 0) {
            return back()->with('error', 'Keranjang belanja kosong.');
        }

        $totalVolume = 0;
        $totalHarga = 0;
        $qtyPickUp = 0;
        $qtyTruck = 0;
        $maxOngPick = 0;
        $maxOngTruck = 0;
        $namaProdukArray = [];

        $shippingRates = \App\Models\ShippingRate::where('ID_Toko', $toko->ID_Toko)->where('is_active', true)->get();
        $ongkirPickupRate = $shippingRates->where('vehicle_type', 'pickup')->first()?->shipping_cost ?? 0;
        $ongkirTruckRate = $shippingRates->where('vehicle_type', 'truck')->first()?->shipping_cost ?? 0;

        foreach ($items as $item) {
            $lineTotal = $item['harga'] * $item['qty'];
            $totalHarga += $lineTotal;
            $totalVolume += $item['qty'];
            $namaProdukArray[] = $item['namaPasir'] . ' (' . $item['qty'] . ' ' . ($item['type'] === 'pickup' ? 'Pick Up' : 'Truk') . ')';

            if ($item['type'] === 'pickup') {
                $qtyPickUp += $item['qty'];
            } else {
                $qtyTruck += $item['qty'];
            }
        }

        // Shipping Calculation: Use store's shipping rates multiplied by quantity
        $ongkirPickUpTotal = $qtyPickUp > 0 ? $ongkirPickupRate * $qtyPickUp : 0;
        $ongkirTruckTotal = $qtyTruck > 0 ? $ongkirTruckRate * $qtyTruck : 0;
        
        $totalOngkir = $ongkirPickUpTotal + $ongkirTruckTotal;
        $grandTotal = $totalHarga + $totalOngkir;
        
        $tipePengiriman = [];
        if ($qtyPickUp > 0) $tipePengiriman[] = 'pickup';
        if ($qtyTruck > 0) $tipePengiriman[] = 'truck';

        $pesanan = Pesanan::create([
            'ID_Akun' => Auth::id(),
            'ID_Toko' => $toko->ID_Toko,
            'Username' => Auth::user()->Username,
            'Nama_Toko' => $toko->Nama_Toko,
            'Lokasi_Toko' => $toko->Lokasi_Toko,
            'Lokasi_Pengantaran' => $request->detail_lokasi,
            'Harga_PickUp' => 0, 
            'Harga_Truck' => 0,
            'Unit' => $totalVolume,
            'Ongkir_PickUp' => $ongkirPickUpTotal,
            'Ongkir_Truck' => $ongkirTruckTotal,
            'Status_Pembayaran' => 'unpaid',
            'Status_Pesanan' => Pesanan::STATUS_PENDING,
            'Tanggal_Pengiriman' => $request->jadwal_pengiriman,
            'nama_pembeli' => $request->nama_penerima,
            'nama_produk' => implode(', ', $namaProdukArray),
            'tipe_pengiriman' => implode(',', $tipePengiriman),
            'total_harga' => $grandTotal,
            'cart_items' => $request->items,
        ]);

        return redirect()->route('ordertracking')->with('success', 'Pesanan berhasil dibuat!');
    }
}
