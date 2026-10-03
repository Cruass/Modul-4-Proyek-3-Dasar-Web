<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Rute rahasia untuk cek data terhapus (Bukti AC-10)
Route::get('/cek-sampah', function () {
    return \App\Models\Activity::onlyTrashed()->get();
});

// 2. Rute fitur status dan restore
Route::patch('/activities/{id}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('/activities/{id}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
Route::patch('/activities/{id}/restore', [ActivityController::class, 'restore'])->name('activities.restore');
Route::get('/activities-trash', [ActivityController::class, 'trash'])->name('activities.trash');

// 3. Rute Resource utama (Harus di paling bawah)
Route::resource('activities', ActivityController::class);