<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Api\MotorsOfVehiclesController;
use App\Http\Controllers\Api\TypesOfAccountsController;
use App\Http\Controllers\Api\TypesOfVehiclesController;
use App\Http\Controllers\Api\VehiclesController;

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

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('sign-in-with-email-and-password', 'signInWithEmailAndPassword');
    });
});

Route::apiResource('accounts', AccountsController::class);
Route::apiResource('cities', CitiesController::class);
Route::apiResource('motors-of-vehicles', MotorsOfVehiclesController::class);
Route::apiResource('types-of-accounts', TypesOfAccountsController::class);
Route::apiResource('types-of-vehicles', TypesOfVehiclesController::class);
Route::apiResource('vehicles', VehiclesController::class);
