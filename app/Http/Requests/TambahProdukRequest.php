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
            'Harga'              => ['required', 'integer', 'min:0'],
            'Ongkir_PickUp'      => ['required', 'integer', 'min:0'],
            'Ongkir_Truck'       => ['required', 'integer', 'min:0'],
            'Kubikasi_PickUp'    => ['required', 'numeric', 'min:0.1'],
            'Kubikasi_Truck'     => ['required', 'numeric', 'min:0.1'],
            'Stock_PickUp'       => ['required', 'integer', 'min:0'],
            'Stock_Truck'        => ['required', 'integer', 'min:0'],
            'Satuan'             => ['required', 'string', 'max:20'],
            'Deskripsi'          => ['nullable', 'string', 'max:1000'],
            'Gambar'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'Lokasi_Pengambilan' => ['nullable', 'string', 'max:200'],
            'Status_Produk'      => ['nullable', 'in:tersedia,habis'],
        ];
    }

    public function messages(): array
    {
        return [
            'Nama_Pasir.required'         => 'Nama pasir wajib diisi.',
            'Harga.required'              => 'Harga pasir wajib diisi.',
            'Harga.integer'               => 'Harga pasir harus berupa angka.',
            'Harga.min'                   => 'Harga pasir tidak boleh negatif.',
            'Ongkir_PickUp.required'      => 'Ongkir Pick Up wajib diisi.',
            'Ongkir_PickUp.integer'       => 'Ongkir Pick Up harus berupa angka.',
            'Ongkir_PickUp.min'           => 'Ongkir Pick Up tidak boleh negatif.',
            'Ongkir_Truck.required'       => 'Ongkir Truck wajib diisi.',
            'Ongkir_Truck.integer'        => 'Ongkir Truck harus berupa angka.',
            'Ongkir_Truck.min'            => 'Ongkir Truck tidak boleh negatif.',
            'Kubikasi_PickUp.required'    => 'Kapasitas Pick Up wajib diisi.',
            'Kubikasi_PickUp.numeric'     => 'Kapasitas Pick Up harus berupa angka.',
            'Kubikasi_PickUp.min'         => 'Kapasitas Pick Up minimal 0.1 m³.',
            'Kubikasi_Truck.required'     => 'Kapasitas Truck wajib diisi.',
            'Kubikasi_Truck.numeric'      => 'Kapasitas Truck harus berupa angka.',
            'Kubikasi_Truck.min'          => 'Kapasitas Truck minimal 0.1 m³.',
            'Stock_PickUp.required'       => 'Stok Pick Up wajib diisi.',
            'Stock_PickUp.integer'        => 'Stok Pick Up harus berupa angka.',
            'Stock_Truck.required'       => 'Stok Truck wajib diisi.',
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
