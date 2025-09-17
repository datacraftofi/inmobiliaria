<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudPublicController;

// Wizard público SIN CSRF (grupo api es stateless)
Route::prefix('solicitudes')->group(function () {
    Route::post('/datos', [SolicitudPublicController::class, 'storeDatos']);
    Route::post('/{solicitud}/referencias', [SolicitudPublicController::class, 'storeReferencias']);
    Route::post('/{solicitud}/soportes', [SolicitudPublicController::class, 'storeSoportes']);
    Route::post('/{solicitud}/firma', [SolicitudPublicController::class, 'storeFirma']);
    Route::get('/solicitudes/{solicitud}/auditorias', [SolicitudPublicController::class, 'auditorias']);
});
