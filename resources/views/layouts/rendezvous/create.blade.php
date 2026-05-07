@extends('layouts.patient')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📋 Nouveau Rendez-vous</h1>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('rendezvous.store') }}" method="POST">
            @csrf

            <!-- Médecin -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Médecin *</label>
                <select name="medecin_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choisir un médecin --</option>
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}"
                            {{ old('medecin_id') == $medecin->id ? 'selected' : '' }}>
                            Dr. {{ $medecin->nom }} {{ $medecin->prenom }} — {{ $medecin->specialite }}
                        </option>
                    @endforeach
                </select>
                @error('medecin_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                <input type="date" name="date" value="{{ old('date') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Heure -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Heure *</label>
                <input type="time" name="heure" value="{{ old('heure') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('heure')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motif -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif de consultation *</label>
                <textarea name="motif" rows="3"
                          placeholder="Décrivez le motif de votre consultation..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('motif') }}</textarea>
                @error('motif')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Confirmer le RDV
                </button>
                <a href="{{ route('rendezvous.index') }}"
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection