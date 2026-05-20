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
        'nama_pembeli',
        'nama_produk',
        'cart_items',
        'tipe_pengiriman',
        'total_harga',
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

    protected $casts = [
        'cart_items' => 'array',
    ];

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
            self::STATUS_PENDING, 'pending'    => 'bg-amber-100 text-amber-700 border border-amber-200',
            'accepted'                         => 'bg-blue-100 text-blue-700 border border-blue-200',
            self::STATUS_DIPROSES, 'diproses'  => 'bg-purple-100 text-purple-700 border border-purple-200',
            self::STATUS_DIKIRIM, 'dikirim'    => 'bg-tertiary/10 text-tertiary border border-tertiary/20',
            self::STATUS_SELESAI, 'selesai'    => 'bg-green-100 text-green-700 border border-green-200',
            self::STATUS_DIBATALKAN, 'dibatalkan' => 'bg-red-100 text-red-600 border border-red-200',
            default                            => 'bg-surface-container text-on-surface-variant border border-outline-variant',
        };
    }

    /**
     * Human-readable status label.
     */
    public function statusLabel(): string
    {
        return match ($this->Status_Pesanan) {
            self::STATUS_PENDING, 'pending'    => 'Menunggu',
            'accepted'                         => 'Diterima',
            self::STATUS_DIPROSES, 'diproses'  => 'Diproses',
            self::STATUS_DIKIRIM, 'dikirim'    => 'Dikirim',
            self::STATUS_SELESAI, 'selesai'    => 'Selesai',
            self::STATUS_DIBATALKAN, 'dibatalkan' => 'Dibatalkan',
            default                            => ucfirst($this->Status_Pesanan ?? ''),
        };
    }

    /**
     * Icon for status badge.
     */
    public function statusIcon(): string
    {
        return match ($this->Status_Pesanan) {
            self::STATUS_PENDING, 'pending'    => 'schedule',
            'accepted'                         => 'check_circle',
            self::STATUS_DIPROSES, 'diproses'  => 'manufacturing',
            self::STATUS_DIKIRIM, 'dikirim'    => 'local_shipping',
            self::STATUS_SELESAI, 'selesai'    => 'task_alt',
            self::STATUS_DIBATALKAN, 'dibatalkan' => 'cancel',
            default                            => 'info',
        };
    }
}
