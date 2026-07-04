<?php

namespace App\Http\Controllers;

use App\Models\IsiToko;
use App\Models\LogStok;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    /**
     * Ambil toko milik user yang login.
     */
    private function getToko(): Toko
    {
        return Toko::where('ID_Akun', Auth::id())->firstOrFail();
    }

    /**
     * Tampilkan halaman stok pasir.
     */
    public function index()
    {
        $toko = $this->getToko();
        $kategoriList = IsiToko::where('ID_Toko', $toko->ID_Toko)
            ->select('Kategori')
            ->distinct()
            ->pluck('Kategori');

        return view('tampilanPenjualStore.stokPasir', compact('toko', 'kategoriList'));
    }

    /**
     * API endpoint: data stok JSON untuk polling AJAX.
     */
    public function data(Request $request)
    {
        $toko = $this->getToko();

        $query = IsiToko::where('ID_Toko', $toko->ID_Toko);

        $shippingRates = \App\Models\ShippingRate::where('ID_Toko', $toko->ID_Toko)
            ->where('is_active', true)
            ->get();
        $ongkirPickup = $shippingRates->where('vehicle_type', 'pickup')->first()?->shipping_cost ?? 0;
        $ongkirTruck = $shippingRates->where('vehicle_type', 'truck')->first()?->shipping_cost ?? 0;

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('Nama_Pasir', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('Kategori', $request->kategori);
        }

        $produk = $query->get()->map(function ($p) use ($ongkirPickup, $ongkirTruck) {
            $totalStok   = $p->Stock_PickUp + $p->Stock_Truck;
            $stokMasuk   = LogStok::where('ID_Isi_Toko', $p->ID_Isi_Toko)
                ->where('tipe', 'masuk')
                ->sum('jumlah');
            $stokKeluar  = LogStok::where('ID_Isi_Toko', $p->ID_Isi_Toko)
                ->where('tipe', 'keluar')
                ->sum('jumlah');

            // Tentukan status stok
            if ($totalStok === 0) {
                $statusStok = 'habis';
            } elseif ($totalStok <= 10) {
                $statusStok = 'menipis';
            } else {
                $statusStok = 'aman';
            }

            return [
                'id'                 => $p->ID_Isi_Toko,
                'nama_pasir'         => $p->Nama_Pasir,
                'kategori'           => $p->Kategori ?? '-',
                'stock_pickup'       => (int) $p->Stock_PickUp,
                'stock_truck'        => (int) $p->Stock_Truck,
                'ongkir_pickup'      => (int) $ongkirPickup,
                'ongkir_truck'       => (int) $ongkirTruck,
                'harga'              => (int) ($p->Harga ?? 0),
                'total_stok'         => (int) $totalStok,
                'stok_masuk'         => (int) $stokMasuk,
                'stok_keluar'        => (int) $stokKeluar,
                'satuan'             => $p->Satuan ?? 'm³',
                'status_produk'      => $p->Status_Produk ?? 'tersedia',
                'status_stok'        => $statusStok,
                'terakhir_diperbarui' => $p->updated_at
                    ? $p->updated_at->diffForHumans()
                    : '-',
                'updated_at_raw'     => $p->updated_at?->toISOString(),
            ];
        });

        // Summary stats untuk widget atas
        $semua     = IsiToko::where('ID_Toko', $toko->ID_Toko)->get();
        $totalProduk = $semua->count();
        $stokAman    = $semua->filter(fn($p) => ($p->Stock_PickUp + $p->Stock_Truck) > 10)->count();
        $stokMenipis = $semua->filter(fn($p) => ($p->Stock_PickUp + $p->Stock_Truck) > 0 && ($p->Stock_PickUp + $p->Stock_Truck) <= 10)->count();
        $stokHabis   = $semua->filter(fn($p) => ($p->Stock_PickUp + $p->Stock_Truck) === 0)->count();

        // Data chart: total stok per kategori
        $chartData = IsiToko::where('ID_Toko', $toko->ID_Toko)
            ->select('Kategori', DB::raw('SUM(Stock_PickUp + Stock_Truck) as total'))
            ->groupBy('Kategori')
            ->get()
            ->map(fn($r) => ['label' => $r->Kategori ?? 'Lainnya', 'value' => (int)$r->total]);

        return response()->json([
            'produk'       => $produk,
            'summary'      => compact('totalProduk', 'stokAman', 'stokMenipis', 'stokHabis'),
            'chart'        => $chartData,
            'last_updated' => now()->format('H:i:s'),
        ]);
    }

    /**
     * Tambah stok (pickup / truck).
     */
    public function tambahStok(Request $request)
    {
        $request->validate([
            'id_produk'  => ['required', 'integer', 'exists:isi_toko,ID_Isi_Toko'],
            'jenis'      => ['required', 'in:pickup,truck'],
            'jumlah'     => ['required', 'integer', 'min:1', 'max:99999'],
            'keterangan' => ['nullable', 'string', 'max:200'],
        ]);

        $toko   = $this->getToko();
        $produk = IsiToko::where('ID_Isi_Toko', $request->id_produk)
            ->where('ID_Toko', $toko->ID_Toko)
            ->firstOrFail();

        DB::transaction(function () use ($produk, $request) {
            if ($request->jenis === 'pickup') {
                $produk->increment('Stock_PickUp', $request->jumlah);
            } else {
                $produk->increment('Stock_Truck', $request->jumlah);
            }

            // Otomatis update status produk jika sebelumnya habis
            $total = $produk->fresh()->Stock_PickUp + $produk->fresh()->Stock_Truck;
            if ($total > 0 && $produk->Status_Produk === 'habis') {
                $produk->update(['Status_Produk' => 'tersedia']);
            }

            LogStok::create([
                'ID_Isi_Toko' => $produk->ID_Isi_Toko,
                'tipe'        => 'masuk',
                'jenis'       => $request->jenis,
                'jumlah'      => $request->jumlah,
                'keterangan'  => $request->keterangan,
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Stok berhasil ditambahkan.']);
    }

    /**
     * Kurangi stok.
     */
    public function kurangiStok(Request $request)
    {
        $request->validate([
            'id_produk'  => ['required', 'integer', 'exists:isi_toko,ID_Isi_Toko'],
            'jenis'      => ['required', 'in:pickup,truck'],
            'jumlah'     => ['required', 'integer', 'min:1', 'max:99999'],
            'keterangan' => ['nullable', 'string', 'max:200'],
        ]);

        $toko   = $this->getToko();
        $produk = IsiToko::where('ID_Isi_Toko', $request->id_produk)
            ->where('ID_Toko', $toko->ID_Toko)
            ->firstOrFail();

        $stokAktif = $request->jenis === 'pickup'
            ? $produk->Stock_PickUp
            : $produk->Stock_Truck;

        if ($request->jumlah > $stokAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok tersedia (' . $stokAktif . ').',
            ], 422);
        }

        DB::transaction(function () use ($produk, $request) {
            if ($request->jenis === 'pickup') {
                $produk->decrement('Stock_PickUp', $request->jumlah);
            } else {
                $produk->decrement('Stock_Truck', $request->jumlah);
            }

            // Otomatis update status produk jika stok habis
            $total = $produk->fresh()->Stock_PickUp + $produk->fresh()->Stock_Truck;
            if ($total === 0) {
                $produk->update(['Status_Produk' => 'habis']);
            }

            LogStok::create([
                'ID_Isi_Toko' => $produk->ID_Isi_Toko,
                'tipe'        => 'keluar',
                'jenis'       => $request->jenis,
                'jumlah'      => $request->jumlah,
                'keterangan'  => $request->keterangan,
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Stok berhasil dikurangi.']);
    }

    /**
     * Update ongkir (pickup / truck).
     */
    public function updateOngkir(Request $request)
    {
        $request->validate([
            'id_produk'  => ['required', 'integer', 'exists:isi_toko,ID_Isi_Toko'],
            'jenis'      => ['required', 'in:pickup,truck'],
            'jumlah'     => ['required', 'integer', 'min:0', 'max:9999999'],
        ]);

        $toko   = $this->getToko();
        $produk = IsiToko::where('ID_Isi_Toko', $request->id_produk)
            ->where('ID_Toko', $toko->ID_Toko)
            ->firstOrFail();

        $oldOngkir = $request->jenis === 'pickup' ? $produk->Ongkir_PickUp : $produk->Ongkir_Truck;

        DB::transaction(function () use ($produk, $request, $oldOngkir) {
            if ($request->jenis === 'pickup') {
                $produk->update(['Ongkir_PickUp' => $request->jumlah]);
            } else {
                $produk->update(['Ongkir_Truck' => $request->jumlah]);
            }

            \App\Models\LogOngkir::create([
                'ID_Isi_Toko' => $produk->ID_Isi_Toko,
                'ongkir_lama' => $oldOngkir,
                'ongkir_baru' => $request->jumlah,
                'jenis'       => $request->jenis,
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Ongkir berhasil diperbarui.']);
    }
}
