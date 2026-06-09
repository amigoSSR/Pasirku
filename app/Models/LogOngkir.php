<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogOngkir extends Model
{
    protected $table = 'log_ongkir';

    protected $fillable = [
        'ID_Isi_Toko',
        'ongkir_lama',
        'ongkir_baru',
        'jenis',
    ];

    public function produk()
    {
        return $this->belongsTo(IsiToko::class, 'ID_Isi_Toko', 'ID_Isi_Toko');
    }
}
