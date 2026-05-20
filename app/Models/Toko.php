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
        'Pendapatan_Toko',
        'Total_Pembelian',
        'Komisi_Admin',
        'Status',
        'Ongkir_PickUp',
        'Ongkir_Truck',
        'Gambar_QRIS',
    ];

    /**
     * Scope: hanya toko yang aktif (status = 'active').
     * Dipakai sebagai Toko::active()->get()
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('Status', 'approved');
    }

    /**
     * Helper: apakah toko ini aktif?
     */
    public function isActive(): bool
    {
        return $this->Status === 'approved';
    }

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
}
