<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RendezVousApiController;
use App\Http\Controllers\Api\AuthApiController;

// Routes publiques — Authentification
Route::post('/login', [AuthApiController::class, 'login']);

// Routes protégées — Token Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me', [AuthApiController::class, 'me']);

    // Rendez-vous
    Route::apiResource('rendezvous', RendezVousApiController::class);

    // Médecins
    Route::get('/medecins', [RendezVousApiController::class, 'medecins']);

});