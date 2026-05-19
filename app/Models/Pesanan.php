<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table      = 'pesanan';
    protected $primaryKey = 'ID_Pesanan';

    protected $fillable = [
        'ID_Akun',
        'ID_Toko',
        'Username',
        'Nama_Toko',
        'Lokasi_Toko',
        'Lokasi_Pengantaran',
        'Harga_PickUp',
        'Harga_Truck',
        'Volume_Pasir',
        'Ongkir_PickUp',
        'Ongkir_Truck',
        'Status_Pembayaran',
        'Status_Pesanan',
        'Jadwal_Pengiriman',
        'nama_pembeli',
        'nama_produk',
        'tipe_pengiriman',
        'total_harga',
        'alasan_tolak',
        'info_pengiriman',
    ];

    protected $casts = [
        'Jadwal_Pengiriman' => 'date',
    ];

    /* ── Status constants ─────────────────────────── */
    const STATUS_PENDING    = 'pending';
    const STATUS_ACCEPTED   = 'accepted';
    const STATUS_DIPROSES   = 'diproses';
    const STATUS_DIKIRIM    = 'dikirim';
    const STATUS_SELESAI    = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    /* ── Relationships ───────────────────────────── */
    public function akun()
    {
        return $this->belongsTo(User::class, 'ID_Akun', 'ID_Akun');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'ID_Toko', 'ID_Toko');
    }

    /* ── Helpers ─────────────────────────────────── */

    /**
     * Returns a Tailwind CSS badge class string for each status.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->Status_Pesanan) {
            'pending'    => 'bg-amber-100 text-amber-700 border-amber-200',
            'accepted'   => 'bg-blue-100 text-blue-700 border-blue-200',
            'diproses'   => 'bg-purple-100 text-purple-700 border-purple-200',
            'dikirim'    => 'bg-tertiary/10 text-tertiary border-tertiary/20',
            'selesai'    => 'bg-green-100 text-green-700 border-green-200',
            'dibatalkan' => 'bg-red-100 text-red-600 border-red-200',
            default      => 'bg-surface-container text-on-surface-variant border-outline-variant',
        };
    }

    /**
     * Human-readable status label.
     */
    public function statusLabel(): string
    {
        return match ($this->Status_Pesanan) {
            'pending'    => 'Menunggu',
            'accepted'   => 'Diterima',
            'diproses'   => 'Diproses',
            'dikirim'    => 'Dikirim',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => ucfirst($this->Status_Pesanan),
        };
    }

    /**
     * Icon for status badge.
     */
    public function statusIcon(): string
    {
        return match ($this->Status_Pesanan) {
            'pending'    => 'schedule',
            'accepted'   => 'check_circle',
            'diproses'   => 'manufacturing',
            'dikirim'    => 'local_shipping',
            'selesai'    => 'task_alt',
            'dibatalkan' => 'cancel',
            default      => 'info',
        };
    }
}
