<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformasiTokoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('informasi_toko')->insert([
            [
                'ID_Akun'              => 1,
                'Nama_Toko'            => 'Toko Pasir Budi',
                'Nomer_Telepon_Toko'   => 6281234567891,
                'Email_Toko'           => 'tokobudi@example.com',
                'Lokasi_Toko'          => 'Jl. Merdeka No. 10, Jakarta',
                'Username'             => 'budi_santoso',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'ID_Akun'              => 2,
                'Nama_Toko'            => 'Pasir Siti Jaya',
                'Nomer_Telepon_Toko'   => 6289876543211,
                'Email_Toko'           => 'tokositi@example.com',
                'Lokasi_Toko'          => 'Jl. Sudirman No. 25, Bandung',
                'Username'             => 'siti_rahayu',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'ID_Akun'              => 3,
                'Nama_Toko'            => 'Joko Pasir Makmur',
                'Nomer_Telepon_Toko'   => 6285555555556,
                'Email_Toko'           => 'tokojoko@example.com',
                'Lokasi_Toko'          => 'Jl. Diponegoro No. 5, Surabaya',
                'Username'             => 'joko_widodo',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);
    }
}
