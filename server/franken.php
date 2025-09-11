#!/usr/bin/env php
<?php

// Pastikan skrip ini diakses dari mode worker
// Jika tidak, tampilkan error
if (! isset($_SERVER['FRANKENPHP_WORKER'])) {
    fwrite(STDERR, 'This script is for FrankenPHP Worker mode only.' . PHP_EOL);
    exit(1);
}

// Muat autoload Composer
require __DIR__ . '/vendor/autoload.php';

// Bootstrap aplikasi Laravel sekali saat startup
$app = require_once __DIR__ . '/bootstrap/app.php';

// Dapatkan kernel HTTP
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Masuk ke mode worker untuk melayani permintaan secara terus-menerus
$app->make(Laravel\Octane\Octane::class)->worker(
    fn(Illuminate\Http\Request $request) => $kernel->handle($request)
);

// Keluar dari kernel setelah selesai
$kernel->terminate($request, $response);

// Catatan: Pastikan `laravel/octane` terinstal
// composer require laravel/octane
