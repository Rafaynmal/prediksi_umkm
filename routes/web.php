<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Home');
});
Route::get('/login', function () {
    return view('login'); 
});
Route::get('/register', function () {
    return view('register'); 
});
Route::get('/dashboard', function () {
    return view('dashboard'); 
});
Route::get('/Prediksi', function () {
    return view('Prediksi'); 
});
Route::get('/Pesan Masuk', function () {
    return view('Pesan Masuk'); 
});
Route::get('/Notifikasi', function () {
    return view('Notifikasi'); 
});
Route::get('/Beranda', function () {
    return view('Beranda'); 
});
Route::get('/Pengguna', function () {
    return view('Pengguna'); 
});
Route::post('/login/submit', function () {
    return redirect('/dashboard');
});
Route::get('/stok', function () {
    return view('stok'); 
});


use App\Http\Controllers\AuthController;

Route::post('/register/submit', [AuthController::class, 'register']);

Route::post('/login/submit', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);




