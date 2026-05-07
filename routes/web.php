<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\MedecinDashboardController;

// Page d'accueil
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->role === 'medecin') {
            return redirect()->route('medecin.dashboard');
        }
        return redirect()->route('rendezvous.index');
    }
    return redirect()->route('login');
});

// Routes Patient
Route::middleware(['auth'])->group(function () {
    Route::get('/rendezvous/export-pdf', [RendezVousController::class, 'exportPdf'])
         ->name('rendezvous.export-pdf');
    Route::resource('rendezvous', RendezVousController::class);
});

// Routes Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
         ->name('admin.dashboard');
    Route::resource('medecins', MedecinController::class);
});

// Routes Medecin
Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::get('/medecin/dashboard', [MedecinDashboardController::class, 'index'])
         ->name('medecin.dashboard');
    Route::post('/medecin/rdv/{id}/confirmer', [MedecinDashboardController::class, 'confirmer'])
         ->name('medecin.confirmer');
    Route::get('/medecin/rdv/{id}/proposer', [MedecinDashboardController::class, 'proposeForm'])
         ->name('medecin.proposer');
    Route::post('/medecin/rdv/{id}/proposer', [MedecinDashboardController::class, 'proposeStore'])
         ->name('medecin.proposer.store');
});

require __DIR__.'/auth.php';