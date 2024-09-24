<?php

use Azuriom\Plugin\Skin3d\Controllers\Skin3dHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/
Route::get('/', [Skin3dHomeController::class, 'index'])->name('index');
Route::get('/3d-api/premium/{pseudo}', [Skin3dHomeController::class, 'show3DModelPremium'])->name('3d.api');
route::get('/3d-api/skin-api/{pseudo}', [Skin3dHomeController::class, 'show3D'])->name('3d');
