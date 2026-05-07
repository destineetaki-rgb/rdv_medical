@extends('layouts.medecin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        Bonjour, Dr. {{ $medecin->nom }} {{ $medecin->prenom }} 👋
    </h1>
    <p class="text-gray-500 mt-1">{{ $medecin->specialite }} — {{ now()->format('d/m/Y') }}</p>
</div>

{{-- Statistiques --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-blue-100 p-4 rounded-full text-3xl">📅</div>
        <div>
            <p class="text-sm text-gray-500">Total RDV</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalRdv }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-green-100 p-4 rounded-full text-3xl">✅</div>
        <div>
            <p class="text-sm text-gray-500">Confirmés</p>
            <p class="text-3xl font-bold text-green-600">{{ $rdvConfirmes }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-yellow-100 p-4 rounded-full text-3xl">⏳</div>
        <div>
            <p class="text-sm text-gray-500">En attente</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $rdvPlanifies }}</p>
        </div>
    </div>
</div>

{{-- RDV du jour --}}
<div class="bg-white rounded-xl shadow overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
        <h2 class="text-lg font-semibold text-green-800">📋 Rendez-vous du jour</h2>
    </div>
    @if($rdvAujourdhui->isEmpty())
        <div class="px-6 py-10 text-center text-gray-500">
            Aucun rendez-vous aujourd'hui.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($rdvAujourdhui as $rdv)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $rdv->heure }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ $rdv->patient->nom ?? '—' }} {{ $rdv->patient->prenom ?? '' }}
                        <br>
                        <span class="text-xs text-gray-500">
                            {{ $rdv->patient->user->email ?? '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->motif }}</td>
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
                        @if($rdv->statut === 'planifié')
                            <form action="{{ route('medecin.confirmer', $rdv->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700 transition">
                                    ✅ Confirmer
                                </button>
                            </form>
                        @endif
                        @if($rdv->statut !== 'annulé')
                            <a href="{{ route('medecin.proposer', $rdv->id) }}"
                               class="bg-orange-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-orange-600 transition">
                                🔄 Autre créneau
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- RDV à venir --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
        <h2 class="text-lg font-semibold text-blue-800">📆 Prochains Rendez-vous</h2>
    </div>
    @if($rdvAVenir->isEmpty())
        <div class="px-6 py-10 text-center text-gray-500">
            Aucun rendez-vous à venir.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($rdvAVenir as $rdv)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                        {{ $rdv->date->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $rdv->heure }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ $rdv->patient->nom ?? '—' }} {{ $rdv->patient->prenom ?? '' }}
                        <br>
                        <span class="text-xs text-gray-500">
                            {{ $rdv->patient->user->email ?? '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->motif }}</td>
                    <td class="px-6 py-4">
                        @php
                            $color = $colors[$rdv->statut] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                            {{ ucfirst($rdv->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        @if($rdv->statut === 'planifié')
                            <form action="{{ route('medecin.confirmer', $rdv->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700 transition">
                                    ✅ Confirmer
                                </button>
                            </form>
                        @endif
                        @if($rdv->statut !== 'annulé')
                            <a href="{{ route('medecin.proposer', $rdv->id) }}"
                               class="bg-orange-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-orange-600 transition">
                                🔄 Autre créneau
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection