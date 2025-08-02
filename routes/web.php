<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\SolicitudPrestamoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('clientes', ClienteController::class)->middleware('auth');
Route::resource('prestamos', PrestamosController::class);

Route::get('solicitudes/crear', [SolicitudPrestamoController::class, 'create'])->name('solicitudes.create');
Route::post('solicitudes', [SolicitudPrestamoController::class, 'store'])->name('solicitudes.store');
Route::get('/solicitudes/pendientes', [SolicitudPrestamoController::class, 'pendientes'])->name('solicitudes.pendientes');

