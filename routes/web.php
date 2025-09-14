<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// Route::get('/export/{record}', function () {
//     return view('export.activity', [$re]);
// });

Route::get('/export/{record}', [ActivityController::class, 'view'])->name('activity.preview');

Route::get('/activity/export/{record}', [ActivityController::class, 'index'])->name('activity.export');
