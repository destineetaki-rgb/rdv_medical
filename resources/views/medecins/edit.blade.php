@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Modifier le Médecin</h1>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('medecins.update', $medecin) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="nom"
                           value="{{ old('nom', $medecin->nom) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="prenom"
                           value="{{ old('prenom', $medecin->prenom) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('prenom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité *</label>
                <input type="text" name="specialite"
                       value="{{ old('specialite', $medecin->specialite) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('specialite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email"
                       value="{{ old('email', $medecin->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                <input type="text" name="telephone"
                       value="{{ old('telephone', $medecin->telephone) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('telephone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Mettre à jour
                </button>
                <a href="{{ route('medecins.index') }}"
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>
@endsection