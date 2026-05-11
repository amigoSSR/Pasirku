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
                'ID_Toko'      => 1,
                'Nama_Pasir'   => 'Pasir Silika',
                'Harga_PickUp' => 150000,
                'Harga_Truck'  => 350000,
                'Stock_PickUp' => 20,
                'Stock_Truck'  => 5,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'ID_Toko'      => 1,
                'Nama_Pasir'   => 'Pasir Bangunan',
                'Harga_PickUp' => 120000,
                'Harga_Truck'  => 280000,
                'Stock_PickUp' => 50,
                'Stock_Truck'  => 10,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Produk Toko 2 (Pasir Siti Jaya)
            [
                'ID_Toko'      => 2,
                'Nama_Pasir'   => 'Pasir Halus',
                'Harga_PickUp' => 130000,
                'Harga_Truck'  => 300000,
                'Stock_PickUp' => 30,
                'Stock_Truck'  => 8,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'ID_Toko'      => 2,
                'Nama_Pasir'   => 'Pasir Kasar',
                'Harga_PickUp' => 100000,
                'Harga_Truck'  => 240000,
                'Stock_PickUp' => 60,
                'Stock_Truck'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Produk Toko 3 (Joko Pasir Makmur)
            [
                'ID_Toko'      => 3,
                'Nama_Pasir'   => 'Pasir Pantai',
                'Harga_PickUp' => 90000,
                'Harga_Truck'  => 210000,
                'Stock_PickUp' => 40,
                'Stock_Truck'  => 12,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'ID_Toko'      => 3,
                'Nama_Pasir'   => 'Pasir Sungai',
                'Harga_PickUp' => 110000,
                'Harga_Truck'  => 260000,
                'Stock_PickUp' => 35,
                'Stock_Truck'  => 7,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
