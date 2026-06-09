<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
Illuminate\Support\Facades\Auth::loginUsingId(22);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/stokPasir/data', 'GET')
);
echo $response->getContent();
