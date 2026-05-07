@extends('layouts.admin')

@section('content')

{{-- En-tête --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">📊 Dashboard Admin</h1>
    <p class="text-gray-500 mt-1">Bienvenue, {{ auth()->user()->name }} — {{ now()->format('d/m/Y') }}</p>
</div>

{{-- Cartes statistiques --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- Total RDV --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-blue-100 p-4 rounded-full text-3xl">📅</div>
        <div>
            <p class="text-sm text-gray-500">Total Rendez-vous</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalRdv }}</p>
        </div>
    </div>

    {{-- Total Médecins --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-green-100 p-4 rounded-full text-3xl">👨‍⚕️</div>
        <div>
            <p class="text-sm text-gray-500">Médecins</p>
            <p class="text-3xl font-bold text-green-600">{{ $totalMedecins }}</p>
        </div>
    </div>

    {{-- Total Patients --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-purple-100 p-4 rounded-full text-3xl">👥</div>
        <div>
            <p class="text-sm text-gray-500">Patients inscrits</p>
            <p class="text-3xl font-bold text-purple-600">{{ $totalPatients }}</p>
        </div>
    </div>

</div>

{{-- Tableau des derniers RDV --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">📋 Derniers Rendez-vous</h2>
        <a href="{{ route('rendezvous.index') }}"
           class="text-blue-600 hover:underline text-sm">Voir tout →</a>
    </div>

    @if($rendezvous->isEmpty())
        <div class="px-6 py-12 text-center text-gray-500">
            Aucun rendez-vous enregistré.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médecin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($rendezvous as $rdv)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                        {{ $rdv->patient->nom ?? '—' }} {{ $rdv->patient->prenom ?? '' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        Dr. {{ $rdv->medecin->nom ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $rdv->date->format('d/m/Y') }} à {{ $rdv->heure }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ Str::limit($rdv->motif, 30) }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'planifié' => 'bg-blue-100 text-blue-700',
                                'confirmé' => 'bg-green-100 text-green-700',
                                'annulé'   => 'bg-red-100 text-red-700',
                                'terminé'  => 'bg-gray-100 text-gray-700',
                            ];
                            $color = $colors[$rdv->statut] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                            {{ ucfirst($rdv->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('rendezvous.edit', $rdv) }}"
                           class="text-blue-600 hover:underline">Modifier</a>
                        <form action="{{ route('rendezvous.destroy', $rdv) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Annuler ce RDV ?')"
                                    class="text-red-600 hover:underline">
                                Annuler
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection