<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStok extends Model
{
    protected $table = 'log_stok';

    protected $fillable = [
        'ID_Isi_Toko',
        'tipe',
        'jenis',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke produk.
     */
    public function produk()
    {
        return $this->belongsTo(IsiToko::class, 'ID_Isi_Toko', 'ID_Isi_Toko');
    }
}
