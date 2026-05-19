<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'toko_id', 'message', 'is_read'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'ID_Akun');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'ID_Akun');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id', 'ID_Toko');
    }
}
