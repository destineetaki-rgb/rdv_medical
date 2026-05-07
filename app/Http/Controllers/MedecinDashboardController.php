<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Notifications\NouveauCreneauPropose;
use Illuminate\Http\Request;

class MedecinDashboardController extends Controller
{
    // Dashboard médecin
    public function index()
    {
        $medecin = auth()->user()->medecin;

        if (!$medecin) {
            abort(403, 'Profil médecin introuvable.');
        }

        $rdvAujourdhui = RendezVous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->whereDate('date', today())
            ->orderBy('heure')
            ->get();

        $rdvAVenir = RendezVous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->whereDate('date', '>', today())
            ->whereIn('statut', ['planifié', 'confirmé'])
            ->orderBy('date')
            ->orderBy('heure')
            ->get();

        $totalRdv       = RendezVous::where('medecin_id', $medecin->id)->count();
        $rdvConfirmes   = RendezVous::where('medecin_id', $medecin->id)->where('statut', 'confirmé')->count();
        $rdvPlanifies   = RendezVous::where('medecin_id', $medecin->id)->where('statut', 'planifié')->count();

        return view('medecin.dashboard', compact(
            'medecin', 'rdvAujourdhui', 'rdvAVenir',
            'totalRdv', 'rdvConfirmes', 'rdvPlanifies'
        ));
    }

    // Confirmer un RDV
    public function confirmer($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'confirmé']);

        return redirect()->route('medecin.dashboard')
            ->with('success', 'Rendez-vous confirmé.');
    }

    // Formulaire — Proposer un autre créneau
    public function proposeForm($id)
    {
        $rdv = RendezVous::with(['patient.user', 'medecin'])->findOrFail($id);
        return view('medecin.proposer-creneau', compact('rdv'));
    }

    // Enregistrer le nouveau créneau + envoyer email
    public function proposeStore(Request $request, $id)
    {
        $rdv = RendezVous::with(['patient.user', 'medecin'])->findOrFail($id);

        $request->validate([
            'nouvelle_date'  => 'required|date|after_or_equal:today',
            'nouvelle_heure' => 'required|date_format:H:i',
            'message'        => 'required|string|min:10',
        ]);

        // Vérifier disponibilité du nouveau créneau
        $exists = RendezVous::where('medecin_id', $rdv->medecin_id)
            ->where('date', $request->nouvelle_date)
            ->where('heure', $request->nouvelle_heure)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['nouvelle_heure' => 'Ce créneau est déjà occupé.']);
        }

        // Sauvegarder ancien créneau
        $ancienneDate  = $rdv->date->format('d/m/Y');
        $ancienneHeure = $rdv->heure;

        // Mettre à jour le RDV
        $rdv->update([
            'date'   => $request->nouvelle_date,
            'heure'  => $request->nouvelle_heure,
            'statut' => 'planifié',
        ]);

        // Envoyer email au patient
        $patientUser = $rdv->patient->user;
        $patientUser->notify(new NouveauCreneauPropose(
            $rdv,
            $ancienneDate,
            $ancienneHeure,
            $request->message
        ));

        return redirect()->route('medecin.dashboard')
            ->with('success', 'Nouveau créneau proposé et email envoyé au patient.');
    }
}