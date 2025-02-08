<nav class="bg-blue-500 text-white p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold">Dashboard</a>
        <div class="flex items-center">
            @auth
                <div class="flex items-center">
                    <span class="mr-2">{{ auth()->user()->name }}</span>
                    <img src="{{ auth()->user()->profile_photo_url ?? 'https://via.placeholder.com/150' }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full border-2 border-white">
                </div>
                <!-- Link do perfil -->
                <a href="{{ route('profile.edit') }}" class="px-4">Perfil</a>
                <!-- Botão de Logout -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Sair</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4">Login</a>
                <a href="{{ route('register') }}" class="px-4">Cadastro</a>
            @endauth
        </div>
    </div>
</nav>
