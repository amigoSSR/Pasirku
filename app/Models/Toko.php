<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Toko extends Model
{
    protected $table      = 'informasi_toko';
    protected $primaryKey = 'ID_Toko';

    protected $fillable = [
        'ID_Akun',
        'Nama_Toko',
        'Nomer_Telepon_Toko',
        'Email_Toko',
        'Lokasi_Toko',
        'Username',
        'Foto_Toko',
        'Pendapatan_Toko',
        'Total_Pembelian',
        'Komisi_Admin',
        'Status',
        'Ongkir_PickUp',
        'Ongkir_Truck',
        'Gambar_QRIS',
        'provinsi',
        'kota',
        'kecamatan',
        'detail_alamat',
        'kode_pos',
        'latitude',
        'longitude',
        'aktif_sampai',
    ];

    protected $casts = [
        'aktif_sampai' => 'date',
    ];

    /**
     * Scope: hanya toko yang aktif (status = 'active').
     * Dipakai sebagai Toko::active()->get()
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('Status', 'approved')
                     ->where(function ($q) {
                         $q->whereNull('aktif_sampai')
                           ->orWhere('aktif_sampai', '>=', now()->toDateString());
                     });
    }

    /**
     * Helper: apakah toko ini aktif?
     */
    public function isActive(): bool
    {
        return $this->Status === 'approved' && !$this->isExpired();
    }

    /* ── Masa Aktif Helpers ────────────────────────────────────────── */

    public function isExpired()
    {
        if (is_null($this->aktif_sampai)) {
            return false;
        }
        return now()->startOfDay()->gt($this->aktif_sampai);
    }

    public function sisaHariAktif()
    {
        if (is_null($this->aktif_sampai)) {
            return null; // Masa aktif belum berjalan
        }
        return max(0, now()->startOfDay()->diffInDays($this->aktif_sampai, false));
    }

    public function isExpiringSoon()
    {
        $sisa = $this->sisaHariAktif();
        return $sisa !== null && $sisa <= 7 && $sisa >= 0;
    }

    /* ── Relationships ─────────────────────────────────────────────── */

    /**
     * Relasi ke pemilik akun (informasi_akun).
     */
    public function akun()
    {
        return $this->belongsTo(User::class, 'ID_Akun', 'ID_Akun');
    }

    /**
     * Relasi ke produk (isi_toko).
     */
    public function produk()
    {
        return $this->hasMany(IsiToko::class, 'ID_Toko', 'ID_Toko');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'ID_Toko', 'ID_Toko');
    }

    public function pembayaranKomisi()
    {
        return $this->hasMany(PembayaranKomisi::class, 'ID_Toko', 'ID_Toko');
    }

    /**
     * Relasi ke review (reviews).
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'ID_Toko', 'ID_Toko');
    }

    /**
     * Relasi ke tarif ongkir (shipping_rates).
     */
    public function shippingRates()
    {
        return $this->hasMany(ShippingRate::class, 'ID_Toko', 'ID_Toko');
    }

    /**
     * Get average rating.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('Rating') ?: 0;
    }

    /**
     * Get rating distribution.
     */
    public function ratingDistribution()
    {
        $counts = $this->reviews()
            ->select('Rating', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('Rating')
            ->pluck('total', 'Rating')
            ->toArray();

        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribution[$i] = $counts[$i] ?? 0;
        }

        return $distribution;
    }
}
