<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'ID_Review';

    protected $fillable = [
        'ID_Pesanan',
        'ID_Akun',
        'ID_Toko',
        'Rating',
        'Ulasan',
        'Foto_Review',
        'is_anonymous',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'ID_Pesanan', 'ID_Pesanan');
    }

    public function akun()
    {
        return $this->belongsTo(User::class, 'ID_Akun', 'ID_Akun');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'ID_Toko', 'ID_Toko');
    }
}
