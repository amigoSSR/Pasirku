<?php

namespace App\Http\Controllers;

use App\Models\ShippingRate;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingRateController extends Controller
{
    /**
     * Display a listing of shipping rates.
     */
    public function index()
    {
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();
        $rates = $toko->shippingRates()->orderBy('vehicle_type')->get();

        return view('tampilanPenjualStore.shipping_rates.index', compact('rates', 'toko'));
    }

    /**
     * Store a newly created shipping rate.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type'  => 'required|in:pickup,truck',
            'capacity'      => 'required|string|max:50',
            'shipping_cost' => 'required|integer|min:0',
            'unit'          => 'required|in:per_trip,per_km',
        ]);

        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();

        $toko->shippingRates()->create([
            'vehicle_type'  => $request->vehicle_type,
            'capacity'      => $request->capacity,
            'shipping_cost' => $request->shipping_cost,
            'unit'          => $request->unit,
            'is_active'     => true,
        ]);

        return back()->with('success', 'Tarif ongkir berhasil ditambahkan!');
    }

    /**
     * Update the specified shipping rate.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_type'  => 'required|in:pickup,truck',
            'capacity'      => 'required|string|max:50',
            'shipping_cost' => 'required|integer|min:0',
            'unit'          => 'required|in:per_trip,per_km',
        ]);

        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();
        $rate = $toko->shippingRates()->findOrFail($id);

        $rate->update($request->all());

        return back()->with('success', 'Tarif ongkir berhasil diperbarui!');
    }

    /**
     * Toggle the active status of a shipping rate.
     */
    public function toggleStatus($id)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();
        $rate = $toko->shippingRates()->findOrFail($id);

        $rate->update(['is_active' => !$rate->is_active]);

        return back()->with('success', 'Status tarif berhasil diubah!');
    }

    /**
     * Remove the specified shipping rate.
     */
    public function destroy($id)
    {
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();
        $rate = $toko->shippingRates()->findOrFail($id);
        $rate->delete();

        return back()->with('success', 'Tarif ongkir berhasil dihapus!');
    }
}
