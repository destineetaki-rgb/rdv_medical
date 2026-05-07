<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - RDV Médical</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased">

<div class="flex min-h-screen">

    <!-- Sidebar Admin -->
    <aside class="w-64 bg-gray-800 text-white flex-shrink-0 flex flex-col">
        <div class="p-6 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">🏥 RDV Médical</h2>
            <p class="text-gray-400 text-sm mt-1">Administration</p>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition">
                📊 Dashboard
            </a>
            <a href="{{ route('medecins.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition">
                👨‍⚕️ Médecins
            </a>
            <a href="{{ route('rendezvous.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition">
                📅 Rendez-vous
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-gray-400 hover:text-white transition">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Zone Principale -->
    <main class="flex-1 p-8">
        <!-- Messages de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Messages d'erreur -->
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

</div>
</body>
</html>