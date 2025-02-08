<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Painel do Usuário - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Barra de navegação diferente -->
        @include('layouts.user-navigation')

        <!-- Cabeçalho exclusivo para usuários -->
        <header class="bg-blue-600 text-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <!-- Nome e Foto do Usuário no lado direito -->
                <div class="flex items-center ml-auto">
                    <img src="{{ auth()->user()->profile_photo_url ?? 'https://via.placeholder.com/150' }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full border-2 border-white mr-2">
                    <h1 class="text-lg font-semibold">{{ auth()->user()->name }}</h1>
                </div>
            </div>
        </header>

        <!-- Conteúdo da Página -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
