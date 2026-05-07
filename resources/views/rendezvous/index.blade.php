@extends('layouts.patient')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📅 Mes Rendez-vous</h1>
    <div class="flex gap-3">
        <a href="{{ route('rendezvous.export-pdf') }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
            📄 Exporter PDF
        </a>
        <a href="{{ route('rendezvous.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Nouveau RDV
        </a>
    </div>
</div>
@if($rendezvous->isEmpty())
    <div class="text-center py-12 bg-white rounded-xl shadow">
        <p class="text-gray-500 text-lg">Aucun rendez-vous trouvé.</p>
        <a href="{{ route('rendezvous.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
            Prendre votre premier RDV
        </a>
    </div>
@else
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Heure</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médecin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($rendezvous as $rdv)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ $rdv->date->format('d/m/Y') }} à {{ $rdv->heure }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        Dr. {{ $rdv->medecin->nom }} {{ $rdv->medecin->prenom }}<br>
                        <span class="text-xs text-gray-500">{{ $rdv->medecin->specialite }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $rdv->motif }}</td>
                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'planifié'  => 'bg-blue-100 text-blue-700',
                                'confirmé'  => 'bg-green-100 text-green-700',
                                'annulé'    => 'bg-red-100 text-red-700',
                                'terminé'   => 'bg-gray-100 text-gray-700',
                            ];
                            $color = $colors[$rdv->statut] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                            {{ ucfirst($rdv->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        @if($rdv->statut !== 'annulé')
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
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection