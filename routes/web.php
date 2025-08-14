<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InteresesController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\SolicitudPrestamoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('clientes', ClienteController::class)->middleware('auth');

Route::get('solicitudes/crear', [SolicitudPrestamoController::class, 'create'])->name('solicitudes.create');
Route::post('solicitudes', [SolicitudPrestamoController::class, 'store'])->name('solicitudes.store');
Route::get('/solicitudes/pendientes', [SolicitudPrestamoController::class, 'pendientes'])->name('solicitudes.pendientes');
Route::resource('prestamos', PrestamoController::class)->middleware('auth');
Route::get('/solicitudes/{id}', [SolicitudPrestamoController::class, 'show'])->name('solicitudes.show');
Route::post('/solicitudes/{id}/aprobar', [SolicitudPrestamoController::class, 'aprobar'])->name('solicitudes.aprobar');


//actualizar perfil
Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index')->middleware('auth');
Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update')->middleware('auth');

Route::get('mis-prestamos', [PrestamoController::class, 'misPrestamos'])
    ->middleware('auth')
    ->name('cliente.prestamos');

Route::get('/mis-prestamos', [PrestamoController::class, 'misPrestamos'])
    ->name('prestamos.mis-prestamos');

// Detalles de préstamo (para el modal)
Route::get('/prestamos/{id}', [PrestamoController::class, 'show'])
    ->name('prestamos.show');

// Rutas para pagos
Route::get('/pagos/create/{prestamo_id}', [PagoController::class, 'create'])
    ->name('pagos.create');
Route::post('/pagos', [PagoController::class, 'store'])
    ->name('pagos.store');

Route::get('/prestamos/{id}', [PrestamoController::class, 'show'])->name('prestamos.show');
Route::get('/dashboard-prestamista', [HomeController::class, 'indexPrestamista'])->name('prestamista.dashboard');
Route::get('/reportes/cartera', [ReporteController::class, 'cartera'])->name('reportes.cartera');
Route::get('/reportes/flujo-cobros', [ReporteController::class, 'flujoCobros'])->name('reportes.flujoCobros');
Route::get('/reportes/flujo-cobros', [ReporteController::class, 'flujoCobros'])->name('reportes.flujoCobros');

//tipoPlazo e interes
Route::get('/intereses', [InteresesController::class, 'index'])->name('intereses.index');

Route::middleware(['auth'])->group(function () {
    // Plazos e Intereses
    Route::get('/plazos-intereses', [InteresesController::class, 'index'])->name('plazos-intereses.index');

    // Rutas para Plazos
    Route::post('/plazos', [InteresesController::class, 'storePlazo'])->name('plazos.store');
    Route::get('/plazos/{id}/edit', [InteresesController::class, 'editPlazo'])->name('plazos.edit');
    Route::put('/plazos/{id}', [InteresesController::class, 'updatePlazo'])->name('plazos.update');
    Route::put('/plazos/{id}/toggle-status', [InteresesController::class, 'toggleStatusPlazo'])->name('plazos.toggle-status');

    // Rutas para Intereses
    Route::post('/intereses', [InteresesController::class, 'storeInteres'])->name('intereses.store');
    Route::get('/intereses/{id}/edit', [InteresesController::class, 'editInteres'])->name('intereses.edit');
    Route::put('/intereses/{id}', [InteresesController::class, 'updateInteres'])->name('intereses.update');
    Route::put('/intereses/{id}/toggle-status', [InteresesController::class, 'toggleStatusInteres'])->name('intereses.toggle-status');

    // Obtener intereses por plazo
    Route::get('/intereses/por-plazo/{id}', [InteresesController::class, 'interesesPorPlazo'])->name('intereses.por-plazo');
});
