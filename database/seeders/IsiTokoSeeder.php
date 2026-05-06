<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IsiTokoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('isi_toko')->insert([
            // Produk Toko 1 (Toko Pasir Budi)
            [
                'ID_Toko'    => 1,
                'Nama_Pasir' => 'Pasir Silika',
                'Harga_Pasir'=> 150000,
                'Stock_Pasir'=> 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ID_Toko'    => 1,
                'Nama_Pasir' => 'Pasir Bangunan',
                'Harga_Pasir'=> 120000,
                'Stock_Pasir'=> 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Produk Toko 2 (Pasir Siti Jaya)
            [
                'ID_Toko'    => 2,
                'Nama_Pasir' => 'Pasir Halus',
                'Harga_Pasir'=> 130000,
                'Stock_Pasir'=> 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ID_Toko'    => 2,
                'Nama_Pasir' => 'Pasir Kasar',
                'Harga_Pasir'=> 100000,
                'Stock_Pasir'=> 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Produk Toko 3 (Joko Pasir Makmur)
            [
                'ID_Toko'    => 3,
                'Nama_Pasir' => 'Pasir Pantai',
                'Harga_Pasir'=> 90000,
                'Stock_Pasir'=> 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ID_Toko'    => 3,
                'Nama_Pasir' => 'Pasir Sungai',
                'Harga_Pasir'=> 110000,
                'Stock_Pasir'=> 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
