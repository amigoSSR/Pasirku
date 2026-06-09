<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranKomisi extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_komisi';

    protected $fillable = [
        'ID_Toko',
        'jumlah_komisi',
        'bukti_pembayaran',
        'status',
        'confirmed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'ID_Toko', 'ID_Toko');
    }
}
