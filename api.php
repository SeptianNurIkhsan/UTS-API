<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Rute untuk registrasi pengguna baru
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');

// Rute untuk login
Route::post('/login', [LoginController::class, 'login'])->name('api.login');

// Grup rute yang membutuhkan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // Rute untuk logout
    Route::post('/logout', [UserController::class, 'logout'])->name('api.logout');

    // Rute-rute untuk pengelolaan kontak
    Route::post('/contacts', [ContactController::class, 'create'])->name('api.contacts.create');
    Route::get('/contacts', [ContactController::class, 'search'])->name('api.contacts.search');
    Route::get('/contacts/{id}', [ContactController::class, 'get'])->name('api.contacts.get');
    Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('api.contacts.update');
    Route::delete('/contacts/{id}', [ContactController::class, 'delete'])->name('api.contacts.delete');

    // Rute-rute untuk pengelolaan alamat
    Route::post('/addresses', [AddressController::class, 'create'])->name('api.addresses.create');
    Route::get('/addresses', [AddressController::class, 'search'])->name('api.addresses.search');
    Route::get('/addresses/{id}', [AddressController::class, 'get'])->name('api.addresses.get');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('api.addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'delete'])->name('api.addresses.delete');
});