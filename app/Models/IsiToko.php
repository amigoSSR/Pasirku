<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsiToko extends Model
{
    protected $table      = 'isi_toko';
    protected $primaryKey = 'ID_Isi_Toko';

    protected $fillable = [
        'ID_Toko',
        'Nama_Pasir',
        'Kategori',
        'Harga',
        'Ongkir_PickUp',
        'Ongkir_Truck',
        'Stock_PickUp',
        'Stock_Truck',
        'Satuan',
        'Deskripsi',
        'Gambar',
        'Lokasi_Pengambilan',
        'Status_Produk',
    ];

    /**
     * Relasi ke toko pemilik.
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'ID_Toko', 'ID_Toko');
    }
}
