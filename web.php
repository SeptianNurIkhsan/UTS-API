<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Tambahkan rute untuk dashboard
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

// Rute untuk pengguna (users)
Route::post('/api/users', [UserController::class, 'register'])->name('api.users.register');
Route::post('/api/users/login', [UserController::class, 'login'])->name('api.users.login');
Route::get('/api/users', [UserController::class, 'getCurrentUser'])->name('api.users.get');
Route::patch('/api/users', [UserController::class, 'updateCurrentUser'])->name('api.users.update');
Route::post('/api/users/logout', [UserController::class, 'logout'])->name('api.users.logout');

// Rute untuk kontak (contacts)
Route::post('/api/contacts', [ContactController::class, 'create'])->name('api.contacts.create');
Route::get('/api/contacts', [ContactController::class, 'search'])->name('api.contacts.search');
Route::get('/api/contacts/{id}', [ContactController::class, 'get'])->name('api.contacts.get');
Route::put('/api/contacts/{id}', [ContactController::class, 'update'])->name('api.contacts.update');
Route::delete('/api/contacts/{id}', [ContactController::class, 'delete'])->name('api.contacts.delete');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create'); 
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

// Rute untuk alamat (addresses)
Route::post('/api/addresses', [AddressController::class, 'create'])->name('api.addresses.create');
Route::get('/api/addresses', [AddressController::class, 'search'])->name('api.addresses.search');
Route::get('/api/addresses/{id}', [AddressController::class, 'get'])->name('api.addresses.get');
Route::put('/api/addresses/{id}', [AddressController::class, 'update'])->name('api.addresses.update');
Route::delete('/api/addresses/{id}', [AddressController::class, 'delete'])->name('api.addresses.delete');
Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create'); 
Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
Route::post('/addresses/create', [AddressController::class, 'store'])->name('addresses.store');

// Rute untuk autentikasi
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login');