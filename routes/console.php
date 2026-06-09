<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-complete pesanan yang statusnya "Dikirim" dan sudah lewat 3 hari dari tanggal pengiriman
Schedule::command('orders:auto-complete')->daily();
