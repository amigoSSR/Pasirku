<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pesanan')->insert([
            // Pesanan dari budi_santoso ke Pasir Siti Jaya
            [
                'ID_Akun'            => 1,
                'ID_Toko'            => 2,
                'Username'           => 'budi_santoso',
                'Nama_Toko'          => 'Pasir Siti Jaya',
                'Lokasi_Toko'        => 'Jl. Sudirman No. 25, Bandung',
                'Lokasi_Pengantaran' => 'Jl. Kebon Jeruk No. 3, Jakarta',
                'Harga_PickUp'       => 130000,
                'Harga_Truck'        => 300000,
                'Volume_Pasir'       => 5,
                'Status_Pembayaran'  => 'Lunas',
                'Status_Pesanan'     => 'Selesai',
                'Jadwal_Pengiriman'  => now()->subDays(2)->format('Y-m-d'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            // Pesanan dari siti_rahayu ke Toko Pasir Budi
            [
                'ID_Akun'            => 2,
                'ID_Toko'            => 1,
                'Username'           => 'siti_rahayu',
                'Nama_Toko'          => 'Toko Pasir Budi',
                'Lokasi_Toko'        => 'Jl. Merdeka No. 10, Jakarta',
                'Lokasi_Pengantaran' => 'Jl. Dago No. 15, Bandung',
                'Harga_PickUp'       => 150000,
                'Harga_Truck'        => 350000,
                'Volume_Pasir'       => 3,
                'Status_Pembayaran'  => 'Lunas',
                'Status_Pesanan'     => 'Dikirim',
                'Jadwal_Pengiriman'  => now()->addDays(1)->format('Y-m-d'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            // Pesanan dari joko_widodo ke Joko Pasir Makmur
            [
                'ID_Akun'            => 3,
                'ID_Toko'            => 3,
                'Username'           => 'joko_widodo',
                'Nama_Toko'          => 'Joko Pasir Makmur',
                'Lokasi_Toko'        => 'Jl. Diponegoro No. 5, Surabaya',
                'Lokasi_Pengantaran' => 'Jl. Ahmad Yani No. 8, Surabaya',
                'Harga_PickUp'       => 90000,
                'Harga_Truck'        => 210000,
                'Volume_Pasir'       => 10,
                'Status_Pembayaran'  => 'Belum Bayar',
                'Status_Pesanan'     => 'Menunggu',
                'Jadwal_Pengiriman'  => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            // Pesanan ke-2 dari budi_santoso ke Joko Pasir Makmur
            [
                'ID_Akun'            => 1,
                'ID_Toko'            => 3,
                'Username'           => 'budi_santoso',
                'Nama_Toko'          => 'Joko Pasir Makmur',
                'Lokasi_Toko'        => 'Jl. Diponegoro No. 5, Surabaya',
                'Lokasi_Pengantaran' => 'Jl. Kebon Jeruk No. 3, Jakarta',
                'Harga_PickUp'       => 110000,
                'Harga_Truck'        => 260000,
                'Volume_Pasir'       => 7,
                'Status_Pembayaran'  => 'Lunas',
                'Status_Pesanan'     => 'Diproses',
                'Jadwal_Pengiriman'  => now()->addDays(3)->format('Y-m-d'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}
