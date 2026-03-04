<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas API v1
Route::prefix('v1')->group(function () {

    // Clients
    Route::apiResource('clients', ClientController::class);

    // Vehicles
    Route::apiResource('vehicles', VehicleController::class);

    // Maintenances
    Route::apiResource('maintenances', MaintenanceController::class);

    // Parts (Repuestos)
    Route::apiResource('parts', PartController::class);

    // Labor (Mano de Obra)
    Route::apiResource('labors', LaborController::class);

    // Reports (Resúmenes de Ingresos)
    Route::get('reports/weekly-revenue', [ReportController::class, 'getWeeklyRevenue']);

});
