<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicWizardController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SolicitudController as AdminSolicitudController;
// (A futuro) controlador de superadmin para gestionar usuarios:
use App\Http\Controllers\Super\UserAdminController;
use App\Http\Middleware\SuperAdminOnly;


use App\Http\Requests\DatosClienteRequest;
use App\Http\Requests\ReferenciasRequest;
use App\Http\Requests\SoportesRequest;
use App\Http\Requests\FirmaRequest;

/* ========================
 *  VISTA PÚBLICA (Landing)
 * ======================== */
Route::get('/', fn () => view('welcome'))->name('landing');

/* ========================
 *  AUTH / PERFIL
 * ======================== */
Route::middleware(['auth'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
    // OJO: quitamos aquí rutas de solicitudes públicas/admin para no duplicar.
});

require __DIR__.'/auth.php';

/* ========================
 *  PDF demo
 * ======================== */
Route::get('/pdf', [PdfController::class, 'demo'])->name('pdf.demo');

// Panel Admin (admin y superadmin tienen acceso)
Route::middleware(['auth','admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/solicitudes', [AdminSolicitudController::class, 'index'])->name('solicitudes.index');
        Route::get('/solicitudes/{solicitud}', [AdminSolicitudController::class, 'show'])->name('solicitudes.show');
    });

Route::middleware(['auth', SuperAdminOnly::class])
    ->prefix('super')->name('super.')
    ->group(function () {
        Route::get('/', [UserAdminController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserAdminController::class, 'create'])->name('users.create');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store');
    });


/* ========================
 *  HEALTH CHECK PÚBLICO
 * ======================== */
Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'time'   => now()->toIso8601String(),
], 200))->name('health');

/* ========================
 *  WIZARD PÚBLICO (solo vistas)
 * ======================== */

// Ruta canónica para iniciar el wizard
Route::get('/solicitud/nueva', [PublicWizardController::class, 'datos'])->name('solicitud.datos');

// Compatibilidad: si alguien visita /solicitud/datos, redirige a /solicitud/nueva
Route::redirect('/solicitud/datos', '/solicitud/nueva');

// Siguientes pasos con el UUID en la URL
Route::get('/solicitud/{solicitud}/referencias', [PublicWizardController::class, 'referencias'])->name('solicitud.referencias');
Route::get('/solicitud/{solicitud}/soportes',    [PublicWizardController::class, 'soportes'])->name('solicitud.soportes');
Route::get('/solicitud/{solicitud}/firma',       [PublicWizardController::class, 'firma'])->name('solicitud.firma');
Route::get('/solicitud/{solicitud}/gracias',     [PublicWizardController::class, 'gracias'])->name('wiz.gracias');

/* ======================================================
 *  DEBUG FASE 2 (SOLO LOCAL): probar FormRequests
 * ====================================================== */
if (app()->environment('local')) {
    Route::prefix('debug')->name('debug.')->group(function () {
        Route::post('/datos', fn (DatosClienteRequest $r) => response()->json([
            'ok' => true,
            'data' => $r->validated(),
        ]))->name('datos');

        Route::post('/referencias', fn (ReferenciasRequest $r) => response()->json([
            'ok' => true,
            'data' => $r->validated(),
        ]))->name('referencias');

        Route::post('/soportes', fn (SoportesRequest $r) => response()->json([
            'ok' => true,
            'files' => array_keys($r->allFiles()),
            'data' => $r->validated(),
        ]))->name('soportes');

        Route::post('/firma', fn (FirmaRequest $r) => response()->json([
            'ok' => true,
            'has_file' => $r->hasFile('firma'),
            'has_b64'  => $r->filled('firma_base64'),
            'data' => $r->validated(),
        ]))->name('firma');
    });
}


Route::get('/super/ping', fn () => response('ok', 200))
    ->middleware(['web','auth','superadmin']);
