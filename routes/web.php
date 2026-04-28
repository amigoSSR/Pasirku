<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('MenuUtama');
})->name('home');
Route::get('/pesan', function () {
    return view('Pesan');
})->name('Pesan');
Route::get('/profil', function () {
    return view('profil');
})->name('profil');
Route::get('/keranjang', function () {
    return view('Keranjang');
})->name('keranjang');
Route::get('/ordertracking', function () {
    return view('ordertracking');
})->name('ordertracking');