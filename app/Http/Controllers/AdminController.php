<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Medecin;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalRdv      = RendezVous::count();
        $totalMedecins = Medecin::count();
        $totalPatients = User::where('role', 'patient')->count();
        $rendezvous    = RendezVous::with(['patient', 'medecin'])
                            ->latest()
                            ->take(10)
                            ->get();

        return view('admin.dashboard', compact(
            'totalRdv',
            'totalMedecins',
            'totalPatients',
            'rendezvous'
        ));
    }
}