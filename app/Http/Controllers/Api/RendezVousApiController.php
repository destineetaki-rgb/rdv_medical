<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Medecin;
use Illuminate\Http\Request;

class RendezVousApiController extends Controller
{
    // GET /api/rendezvous
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $rendezvous = RendezVous::with(['patient', 'medecin'])->latest()->get();
        } else {
            $rendezvous = RendezVous::with(['medecin'])
                ->where('patient_id', optional($user->patient)->id ?? 0)
                ->latest()
                ->get();
        }

        return response()->json([
            'success' => true,
            'data'    => $rendezvous,
            'total'   => $rendezvous->count(),
        ]);
    }

    // GET /api/rendezvous/{id}
    public function show($id)
    {
        $rdv = RendezVous::with(['patient', 'medecin'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $rdv,
        ]);
    }

    // POST /api/rendezvous
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => 'required|date_format:H:i',
            'motif'      => 'required|string|min:5',
        ]);

        $exists = RendezVous::where('medecin_id', $validated['medecin_id'])
            ->where('date', $validated['date'])
            ->where('heure', $validated['heure'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ce créneau est déjà réservé.',
            ], 422);
        }

        $validated['patient_id'] = optional($request->user()->patient)->id;
        $validated['statut'] = 'planifié';

        $rdv = RendezVous::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous créé avec succès.',
            'data'    => $rdv->load('medecin'),
        ], 201);
    }

    // PUT /api/rendezvous/{id}
    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);

        $validated = $request->validate([
            'date'  => 'sometimes|date|after_or_equal:today',
            'heure' => 'sometimes|date_format:H:i',
            'motif' => 'sometimes|string|min:5',
        ]);

        $rdv->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous mis à jour.',
            'data'    => $rdv,
        ]);
    }

    // DELETE /api/rendezvous/{id}
    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annulé']);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous annulé.',
        ]);
    }

    // GET /api/medecins
    public function medecins()
    {
        $medecins = Medecin::all();

        return response()->json([
            'success' => true,
            'data'    => $medecins,
        ]);
    }
}