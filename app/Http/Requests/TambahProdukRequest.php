<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TambahProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Nama_Pasir'         => ['required', 'string', 'max:100'],
            'Kategori'           => ['required', 'string', 'max:50'],
            'Harga_PickUp'       => ['required', 'integer', 'min:0'],
            'Harga_Truck'        => ['required', 'integer', 'min:0'],
            'Stock_PickUp'       => ['required', 'integer', 'min:0'],
            'Stock_Truck'        => ['required', 'integer', 'min:0'],
            'Satuan'             => ['required', 'string', 'max:20'],
            'Deskripsi'          => ['nullable', 'string', 'max:1000'],
            'Gambar'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'Lokasi_Pengambilan' => ['required', 'string', 'max:200'],
            'Status_Produk'      => ['required', 'in:tersedia,habis'],
        ];
    }

    public function messages(): array
    {
        return [
            'Nama_Pasir.required'         => 'Nama pasir wajib diisi.',
            'Kategori.required'           => 'Kategori wajib dipilih.',
            'Harga_PickUp.required'       => 'Harga Pick Up wajib diisi.',
            'Harga_PickUp.integer'        => 'Harga Pick Up harus berupa angka.',
            'Harga_PickUp.min'            => 'Harga Pick Up tidak boleh negatif.',
            'Harga_Truck.required'        => 'Harga Truck wajib diisi.',
            'Harga_Truck.integer'         => 'Harga Truck harus berupa angka.',
            'Harga_Truck.min'             => 'Harga Truck tidak boleh negatif.',
            'Stock_PickUp.required'       => 'Stok Pick Up wajib diisi.',
            'Stock_PickUp.integer'        => 'Stok Pick Up harus berupa angka.',
            'Stock_Truck.required'        => 'Stok Truck wajib diisi.',
            'Stock_Truck.integer'         => 'Stok Truck harus berupa angka.',
            'Satuan.required'             => 'Satuan wajib diisi.',
            'Gambar.image'                => 'File harus berupa gambar.',
            'Gambar.mimes'                => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'Gambar.max'                  => 'Ukuran gambar maksimal 2 MB.',
            'Lokasi_Pengambilan.required' => 'Lokasi pengambilan wajib diisi.',
            'Status_Produk.required'      => 'Status produk wajib dipilih.',
            'Status_Produk.in'            => 'Status produk tidak valid.',
        ];
    }
}
