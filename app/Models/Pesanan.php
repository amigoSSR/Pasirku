<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'ID_Pesanan';

    const STATUS_PENDING = 'Belum Diterima Toko';
    const STATUS_DIPROSES = 'Diproses';
    const STATUS_DIKIRIM = 'Dikirim';
    const STATUS_SELESAI = 'Selesai';
    const STATUS_DIBATALKAN = 'Dibatalkan';

    protected $fillable = [
        'ID_Akun',
        'ID_Toko',
        'Username',
        'Nama_Toko',
        'Lokasi_Toko',
        'Lokasi_Pengantaran',
        'Harga_PickUp',
        'Harga_Truck',
        'Unit',
        'Ongkir_PickUp',
        'Ongkir_Truck',
        'Status_Pembayaran',
        'Status_Pesanan',
        'Bukti_Pembayaran',
        'Tanggal_Pengiriman',
        'Jam_Tiba',
        'alasan_tolak',
        'info_pengiriman',
    ];

    public function akun()
    {
        return $this->belongsTo(User::class, 'ID_Akun', 'ID_Akun');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'ID_Toko', 'ID_Toko');
    }
}
