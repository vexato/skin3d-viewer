<?php

use Azuriom\Plugin\Skin3d\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/3d-api', [AdminController::class, 'api'])->name('api');
Route::post('/update', [AdminController::class, 'update'])->name('update');
