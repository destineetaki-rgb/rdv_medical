<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = Medecin::latest()->get();
        return view('medecins.index', compact('medecins'));
    }

    public function create()
    {
        return view('medecins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'        => 'required|string|max:100',
            'prenom'     => 'required|string|max:100',
            'specialite' => 'required|string|max:100',
            'telephone'  => 'required|string|max:20',
            'email'      => 'required|email|unique:medecins,email',
        ]);

        Medecin::create($validated);

        return redirect()->route('medecins.index')
            ->with('success', 'Médecin ajouté avec succès.');
    }

    public function show($id)
    {
        $medecin = Medecin::findOrFail($id);
        return view('medecins.show', compact('medecin'));
    }

    public function edit($id)
    {
        $medecin = Medecin::findOrFail($id);
        return view('medecins.edit', compact('medecin'));
    }

    public function update(Request $request, $id)
    {
        $medecin = Medecin::findOrFail($id);

        $validated = $request->validate([
            'nom'        => 'required|string|max:100',
            'prenom'     => 'required|string|max:100',
            'specialite' => 'required|string|max:100',
            'telephone'  => 'required|string|max:20',
            'email'      => 'required|email|unique:medecins,email,' . $id,
        ]);

        $medecin->update($validated);

        return redirect()->route('medecins.index')
            ->with('success', 'Médecin mis à jour.');
    }

    public function destroy($id)
    {
        $medecin = Medecin::findOrFail($id);
        $medecin->delete();

        return redirect()->route('medecins.index')
            ->with('success', 'Médecin supprimé.');
    }
}