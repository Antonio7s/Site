@extends('layouts.layout-index')

@push('styles')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container-custom {
            max-width: 1200px;
        }
        /* Sidebar fixa para desktop */
        .sidebar-desktop {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .sidebar-desktop ul {
            padding: 0;
            list-style: none;
        }
        .sidebar-desktop ul li a {
            display: block;
            padding: 12px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
            transition: 0.3s;
        }
        .sidebar-desktop ul li a:hover,
        .sidebar-desktop ul li a.active {
            background: #007bff;
            color: #fff;
        }
        /* Offcanvas Sidebar para mobile */
        .offcanvas .nav-link {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <!-- Barra de Navegação -->
    <nav class="bg-blue-500 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold">Dashboard</a>
            <div>
                @auth
                    <a href="{{ route('profile.edit') }}" class="px-4">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4">Login</a>
                    <a href="{{ route('register') }}" class="px-4">Cadastro</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Offcanvas Sidebar (mobile) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Painel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Meus Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Exames</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Endereços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pagamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Suporte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sair</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container container-custom my-5">
        <div class="row">
            <!-- Sidebar fixa para desktop -->
            <div class="col-md-3 d-none d-md-block">
                <div class="sidebar-desktop">
                    <h4 class="mb-3">Painel</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Página Inicial</a></li>
                        <li><a href="#" class="active">Dashboard</a></li>
                        <li><a href="#">Meus Pedidos</a></li>
                        <li><a href="#">Exames</a></li>
                        <li><a href="#">Endereços</a></li>
                        <li><a href="#">Pagamentos</a></li>
                        <li><a href="#">Suporte</a></li>
                        <li><a href="#">Sair</a></li>
                    </ul>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Olá, {{ auth()->user()->name }} 👋</h2>
                    <!-- Botão para offcanvas (apenas em mobile) -->
                    <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                        Menu
                    </button>
                </div>
                <div class="row">
                    <!-- Card: Últimos Pedidos -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                🛒 Últimos Pedidos
                            </div>
                            <div class="card-body">
                                @if(isset($purchaseHistory) && $purchaseHistory->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach($purchaseHistory->take(3) as $purchase)
                                            <li class="list-group-item">
                                                <strong>Pedido #{{ $purchase->id }}</strong><br>
                                                <small class="text-muted">Status: {{ ucfirst($purchase->status) }}</small><br>
                                                <span class="text-success">R$ {{ number_format($purchase->total, 2, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="#" class="btn btn-primary btn-sm mt-3">Ver todos</a>
                                @else
                                    <p class="text-center text-muted">Nenhuma compra recente.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card: Exames -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                💖 Exames
                            </div>
                            <div class="card-body">
                                @if(isset($wishlist) && $wishlist->isNotEmpty())
                                    <div class="row g-3">
                                        @foreach($wishlist->take(2) as $item)
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <img src="{{ $item->image ?? 'https://via.placeholder.com/200' }}" class="card-img-top" alt="{{ $item->product_name }}">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title">{{ $item->product_name }}</h5>
                                                        <p class="card-text text-success">R$ {{ number_format($item->price, 2, ',', '.') }}</p>
                                                        <a href="#" class="btn btn-warning btn-sm">Comprar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="#" class="btn btn-info btn-sm mt-3">Ver todos</a>
                                @else
                                    <p class="text-center text-muted">Nenhum exame cadastrado.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card: Profissionais em destaque -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                🔥 Profissionais em destaque
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @if(isset($recommendedProducts) && count($recommendedProducts))
                                        @foreach($recommendedProducts as $product)
                                            <div class="col-md-4">
                                                <div class="card h-100">
                                                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->product_name }}">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                                        <p class="card-text text-success">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                                                        <a href="#" class="btn btn-warning btn-sm">Comprar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center text-muted">Nenhum profissional destacado.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
