@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">👨‍⚕️ Gestion des Médecins</h1>
    <a href="{{ route('medecins.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        + Ajouter un Médecin
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom Complet</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spécialité</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($medecins as $medecin)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-500">{{ $medecin->id }}</td>
                <td class="px-6 py-4 font-medium text-gray-900">
                    Dr. {{ $medecin->nom }} {{ $medecin->prenom }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                        {{ $medecin->specialite }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $medecin->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $medecin->telephone }}</td>
                <td class="px-6 py-4 text-sm space-x-3">
                    <a href="{{ route('medecins.edit', $medecin) }}"
                       class="text-blue-600 hover:underline font-medium">Modifier</a>
                    <form action="{{ route('medecins.destroy', $medecin) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Supprimer ce médecin ?')"
                                class="text-red-600 hover:underline font-medium">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    Aucun médecin enregistré.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection