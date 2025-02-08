<nav class="bg-blue-500 text-white p-4">
    <div class="max-w-7xl mx-auto flex justify-end items-center">
        @auth
            <!-- Foto de perfil e links de Perfil e Sair -->
            <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/50' }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-circle ml-3">
            <a href="{{ route('profile.edit') }}" class="px-4 text-white">Perfil</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 text-white">Sair</button>
            </form>
        @else
            <!-- Links de Login e Cadastro removidos aqui -->
        @endauth
    </div>
</nav>
