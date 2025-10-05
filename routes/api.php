<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/clients', [ClientController::class, 'index']);

Route::get('/clients/{id}', [ClientController::class, 'show']);

Route::post('/clients', [ClientController::class, 'store']);

Route::put('/clients/{id}', [ClientController::class, 'update']);

Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

