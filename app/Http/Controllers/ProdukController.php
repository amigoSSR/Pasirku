<?php

namespace App\Http\Controllers;

use App\Http\Requests\TambahProdukRequest;
use App\Models\IsiToko;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Tampilkan form tambah produk.
     */
    public function create()
    {
        return view('tampilanPenjualStore.tambahProduk');
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(TambahProdukRequest $request)
    {
        // Ambil toko milik user yang sedang login
        $toko = Toko::where('ID_Akun', Auth::id())->firstOrFail();

        // Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('Gambar')) {
            $gambarPath = $request->file('Gambar')->store('produk', 'public');
        }

        IsiToko::create([
            'ID_Toko'            => $toko->ID_Toko,
            'Nama_Pasir'         => $request->Nama_Pasir,
            'Harga'              => $request->Harga,
            'Ongkir_PickUp'      => $request->Ongkir_PickUp,
            'Ongkir_Truck'       => $request->Ongkir_Truck,
            'Kubikasi_PickUp'    => $request->Kubikasi_PickUp ?? 1,
            'Kubikasi_Truck'     => $request->Kubikasi_Truck ?? 1,
            'Stock_PickUp'       => $request->Stock_PickUp,
            'Stock_Truck'        => $request->Stock_Truck,
            'Satuan'             => $request->Satuan,
            'Deskripsi'          => $request->Deskripsi,
            'Gambar'             => $gambarPath,
            'Lokasi_Pengambilan' => $request->Lokasi_Pengambilan ?? $toko->detail_alamat,
            'Status_Produk'      => $request->Status_Produk ?? 'tersedia',
        ]);

        return redirect()
            ->route('tambahProduk')
            ->with('success', 'Produk berhasil ditambahkan!');
    }
}
