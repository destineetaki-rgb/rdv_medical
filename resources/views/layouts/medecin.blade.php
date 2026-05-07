<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Médecin - RDV Medical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-6">
                    <span class="text-xl font-bold text-green-600">🩺 Espace Médecin</span>
                    <a href="{{ route('medecin.dashboard') }}"
                       class="text-gray-600 hover:text-green-600 font-medium transition">
                        Dashboard
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-500 text-sm">
                        Dr. {{ auth()->user()->medecin->nom ?? auth()->user()->name }}
                        {{ auth()->user()->medecin->prenom ?? '' }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-gray-500 hover:text-red-600 transition text-sm">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>