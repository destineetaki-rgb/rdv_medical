@extends('layouts.medecin')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">🔄 Proposer un Nouveau Créneau</h1>
    <p class="text-gray-500 mb-6">Le patient recevra un email avec le nouveau créneau proposé.</p>

    {{-- Infos RDV actuel --}}
    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6">
        <h2 class="font-semibold text-orange-800 mb-2">📋 Créneau actuel</h2>
        <p class="text-sm text-orange-700">
            <strong>Patient :</strong>
            {{ $rdv->patient->nom ?? '—' }} {{ $rdv->patient->prenom ?? '' }}
        </p>
        <p class="text-sm text-orange-700">
            <strong>Date :</strong> {{ $rdv->date->format('d/m/Y') }}
            à {{ $rdv->heure }}
        </p>
        <p class="text-sm text-orange-700">
            <strong>Motif :</strong> {{ $rdv->motif }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('medecin.proposer.store', $rdv->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nouvelle Date *
                </label>
                <input type="date" name="nouvelle_date"
                       value="{{ old('nouvelle_date') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                @error('nouvelle_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nouvelle Heure *
                </label>
                <input type="time" name="nouvelle_heure"
                       value="{{ old('nouvelle_heure') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                @error('nouvelle_heure')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Message au patient * (expliquer la raison)
                </label>
                <textarea name="message" rows="4"
                          placeholder="Ex: En raison d'une urgence médicale, je vous propose un nouveau créneau..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                    📧 Envoyer la proposition
                </button>
                <a href="{{ route('medecin.dashboard') }}"
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection