<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Medecin;
use App\Http\Requests\StoreRendezVousRequest;
use App\Notifications\RendezVousConfirme;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RendezVousController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $rendezvous = RendezVous::with(['patient', 'medecin'])
            ->where('patient_id', optional($user->patient)->id ?? 0)
            ->latest()
            ->get();

        return view('rendezvous.index', compact('rendezvous'));
    }

    public function create()
    {
        $medecins = Medecin::all();
        return view('rendezvous.create', compact('medecins'));
    }

    public function store(StoreRendezVousRequest $request)
    {
        $validated = $request->validated();

        $exists = RendezVous::where('medecin_id', $validated['medecin_id'])
            ->where('date', $validated['date'])
            ->where('heure', $validated['heure'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['creneau' => 'Ce créneau est déjà réservé.']);
        }

        $validated['patient_id'] = optional(auth()->user()->patient)->id;
        $validated['statut'] = 'planifié';

        // Créer le RDV
        $rdv = RendezVous::create($validated);

        // ✅ Envoyer la notification email
        /** @var \App\Models\User $user */
$user = auth()->user();
$user->notify(new RendezVousConfirme($rdv->load('medecin')));

        return redirect()->route('rendezvous.index')
            ->with('success', 'Votre rendez-vous est confirmé. Un email vous a été envoyé.');
    }

    public function edit($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $medecins = Medecin::all();

        if (auth()->user()->role === 'patient') {
            if ($rdv->patient_id !== optional(auth()->user()->patient)->id) {
                abort(403, 'Action non autorisée.');
            }
        }

        return view('rendezvous.edit', compact('rdv', 'medecins'));
    }

    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);

        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => 'required|date_format:H:i',
            'motif'      => 'required|string|min:5',
        ]);

        $rdv->update($validated);

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous mis à jour.');
    }

    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annulé']);

        return redirect()->route('rendezvous.index')
            ->with('success', 'Rendez-vous annulé.');
    }
    public function exportPdf()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        $rendezvous = RendezVous::with(['patient', 'medecin'])->latest()->get();
    } else {
        $rendezvous = RendezVous::with(['patient', 'medecin'])
            ->where('patient_id', optional($user->patient)->id ?? 0)
            ->latest()
            ->get();
    }

    $pdf = Pdf::loadView('pdf.rendezvous', compact('rendezvous', 'user'));

    return $pdf->download('mes-rendezvous-' . now()->format('d-m-Y') . '.pdf');
}
}