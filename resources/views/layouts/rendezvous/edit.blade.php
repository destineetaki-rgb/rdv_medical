@extends('layouts.patient')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Modifier le Rendez-vous</h1>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('rendezvous.update', $rdv) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Médecin -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Médecin *</label>
                <select name="medecin_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}"
                            {{ $rdv->medecin_id == $medecin->id ? 'selected' : '' }}>
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
                <input type="date" name="date"
                       value="{{ old('date', $rdv->date->format('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Heure -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Heure *</label>
                <input type="time" name="heure"
                       value="{{ old('heure', $rdv->heure) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('heure')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motif -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif *</label>
                <textarea name="motif" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('motif', $rdv->motif) }}</textarea>
                @error('motif')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Mettre à jour
                </button>
                <a href="{{ route('rendezvous.index') }}"
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>
@endsection