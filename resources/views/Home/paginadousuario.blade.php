<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário - MeuSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card { margin-bottom: 20px; }
        .navbar-brand { font-weight: bold; }
        .menu-lateral {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu-lateral a { 
            display: block; 
            padding: 10px; 
            color: #333;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu-lateral a:hover {
            background: #007bff;
            color: white;
        }
        .menu-lateral .active {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">MeuSite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Perfil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container Principal -->
    <div class="container my-4">
        <div class="row">
            <!-- Menu Lateral -->
            <div class="col-md-3">
                <div class="menu-lateral">
                    <h5 class="fw-bold">Painel</h5>
                    <a href="#" class="active">Dashboard</a>
                    <a href="#">Meus Pedidos</a>
                    <a href="#">Lista de Desejos</a>
                    <a href="#">Endereços</a>
                    <a href="#">Pagamentos</a>
                    <a href="#">Suporte</a>
                    <a href="#">Sair</a>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <div class="col-md-9">
                <h4 class="fw-bold mb-3">Olá, {{ auth()->user()->name }}</h4>

                <div class="row">
                    <!-- Pedidos Recentes -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Últimos Pedidos</h5>
                            </div>
                            <div class="card-body">
                                @if(isset($purchaseHistory) && $purchaseHistory->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach($purchaseHistory->take(3) as $purchase)
                                            <li class="list-group-item">
                                                Pedido #{{ $purchase->id }} - 
                                                R$ {{ number_format($purchase->total, 2, ',', '.') }} <br>
                                                <span class="text-muted">Status: {{ ucfirst($purchase->status) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="#" class="btn btn-primary btn-sm mt-2">Ver todos</a>
                                @else
                                    <p class="text-muted">Nenhuma compra recente.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Desejos -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Lista de Desejos</h5>
                            </div>
                            <div class="card-body">
                                @if(isset($wishlist) && $wishlist->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach($wishlist->take(3) as $item)
                                            <li class="list-group-item">
                                                {{ $item->product_name }} - 
                                                <span class="text-muted">R$ {{ number_format($item->price, 2, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="#" class="btn btn-info btn-sm mt-2">Ver todos</a>
                                @else
                                    <p class="text-muted">Nenhum item na lista de desejos.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Endereços -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Endereços de Entrega</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($addresses) && $addresses->isNotEmpty())
                            <ul class="list-group">
                                @foreach($addresses as $address)
                                    <li class="list-group-item">
                                        {{ $address->street }}, {{ $address->number }} - {{ $address->city }}/{{ $address->state }}
                                    </li>
                                @endforeach
                            </ul>
                            <a href="#" class="btn btn-warning btn-sm mt-2">Gerenciar Endereços</a>
                        @else
                            <p class="text-muted">Nenhum endereço cadastrado.</p>
                            <a href="#" class="btn btn-warning btn-sm">Adicionar Endereço</a>
                        @endif
                    </div>
                </div>

                <!-- Chat de Suporte -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Suporte</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Precisa de ajuda? Entre em contato com o suporte.</p>
                        <a href="#" class="btn btn-danger btn-sm">Abrir Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-primary text-white text-center py-3 mt-4">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} MeuSite. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

