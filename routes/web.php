<?php

use Illuminate\Support\Facades\Route;

Route::get('/MenuUtama', function () {
    return view('MenuUtama');
})->name('home');
Route::get('/pesan', function () {
    return view('Pesan');
})->name('Pesan');
