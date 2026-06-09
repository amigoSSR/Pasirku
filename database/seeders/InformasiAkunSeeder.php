<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InformasiAkunSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus data lama beserta relasi yang on cascade
        DB::table('informasi_akun')->delete();

        DB::table('informasi_akun')->insert([
            [
                'Username'       => 'budi_santoso',
                'Nomer_Telepon'  => '6281234567890',
                'Email'          => 'budi@example.com',
                'Password'       => Hash::make('password123'),
                'Role'           => 'admin',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'Username'       => 'iyyan',
                'Nomer_Telepon'  => '082188936473',
                'Email'          => 'iyyan@example.com',
                'Password'       => Hash::make('12345678'),
                'Role'           => 'admin',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'Username'       => 'siti_rahayu',
                'Nomer_Telepon'  => '6289876543210',
                'Email'          => 'siti@example.com',
                'Password'       => Hash::make('password456'),
                'Role'           => 'user',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'Username'       => 'joko_widodo',
                'Nomer_Telepon'  => '6285555555555',
                'Email'          => 'joko@example.com',
                'Password'       => Hash::make('h'),
                'Role'           => 'user',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'Username'       => 'pemilik_toko',
                'Nomer_Telepon'  => '6281112223334',
                'Email'          => 'pemilik@example.com',
                'Password'       => Hash::make('password123'),
                'Role'           => 'user',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
