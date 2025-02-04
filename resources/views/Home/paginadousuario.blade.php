<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Usuário</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        footer {
            margin-top: 40px;
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

    <!-- Conteúdo Principal -->
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-4">Bem-vindo, {{ auth()->user()->name }}!</h1>
                <p class="lead">Acompanhe seu histórico de compras e veja as compras realizadas hoje.</p>
            </div>
        </div>

        <div class="row">
            <!-- Histórico de Compras -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">Histórico de Compras</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($purchaseHistory) && $purchaseHistory->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Data</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchaseHistory as $purchase)
                                            <tr>
                                                <td>{{ $purchase->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('d/m/Y') }}</td>
                                                <td>R$ {{ number_format($purchase->total, 2, ',', '.') }}</td>
                                                <td>{{ ucfirst($purchase->status) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Você ainda não realizou nenhuma compra.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Compras de Hoje -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Compras de Hoje</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($todayPurchases) && $todayPurchases->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hora</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($todayPurchases as $purchase)
                                            <tr>
                                                <td>{{ $purchase->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('H:i') }}</td>
                                                <td>R$ {{ number_format($purchase->total, 2, ',', '.') }}</td>
                                                <td>{{ ucfirst($purchase->status) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Nenhuma compra realizada hoje.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhes do Perfil -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detalhes do Usuário</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Data de Cadastro:</strong> {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d/m/Y') }}</p>
                        <!-- Outras informações podem ser adicionadas aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} MeuSite. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
