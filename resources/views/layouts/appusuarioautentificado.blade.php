<!DOCTYPE html>  
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Painel do Usuário - {{ config('app.name', 'Laravel') }}</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome para os ícones das redes sociais -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  @stack('styles')

  <style>
    body {
      font-family: 'Figtree', sans-serif;
      background: #f5f5f5;
    }
    .custom-header {
      background-color: #007bff;
      color: #fff;
    }
    .custom-header a {
      color: #fff;
      text-decoration: none;
      margin-right: 15px;
    }
    .custom-header a:hover {
      text-decoration: underline;
    }
    .custom-footer {
      background-color: #007bff;
      color: #fff;
      padding: 40px 0;
    }
    .custom-footer a {
      color: #fff;
      text-decoration: none;
    }
    .custom-footer a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .custom-header .d-flex {
        flex-direction: column;
        align-items: flex-start;
      }
      .custom-header .d-flex a {
        margin: 5px 0;
      }
      .custom-footer .row {
        flex-direction: column;
      }
      .custom-footer .col-md-4 {
        margin-bottom: 20px;
      }
    }
    .offcanvas-body {
      overflow-y: auto;
    }
  </style>
</head>
<body>
  <!-- Cabeçalho -->
  <header class="custom-header py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <a href="{{ url('/') }}" class="me-3">
          <img src="https://i.postimg.cc/mhK2Fhr6/logomed.png" alt="Minha Logo" style="height:40px;">
        </a>
        <a href="{{ url('/politicas-de-privacidade') }}" class="me-3 d-none d-md-inline">Políticas de Privacidade</a>
        <a href="{{ url('/sobre-a-medexame') }}" class="d-none d-md-inline">Sobre a Medexames</a>
      </div>
      <div class="d-flex align-items-center">
        @auth
        <div class="dropdown">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item">Sair</button>
              </form>
            </li>
          </ul>
        </div>
        @else
        <a href="{{ url('/login') }}" class="me-2">Login</a>
        <a href="{{ url('/register') }}">Cadastro</a>
        @endauth
      </div>
    </div>
  </header>

  <!-- Sidebar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">Painel</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Página Inicial</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Minhas Informações</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Meus Pedidos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Exames</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Endereços</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Pagamentos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Suporte</a></li>
        @auth
        <li class="nav-item mt-3">
          <a href="{{ url('perfil/meus-pedidos') }}" class="btn btn-primary w-100">Meus Pedidos</a>
        </li>
        <li class="nav-item mt-2">
          <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Sair</button>
          </form>
        </li>
        @endauth
      </ul>
    </div>
  </div>

  <!-- Conteúdo -->
  <div class="container my-4">
    @auth
    <div class="text-center mb-4">
      <h2>Olá, {{ auth()->user()->name }} 👋</h2>
    </div>
    @endauth
    @yield('content')
  </div>

  <!-- Rodapé -->
  <footer class="custom-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>Medexames</h5>
          <ul class="list-unstyled">
            <li><a href="{{ url('/sobre-a-medexame') }}">Sobre</a></li>
            <li><a href="{{ url('/politicas-de-privacidade') }}">Políticas de Privacidade</a></li>
            <li><a href="{{ url('/contact') }}">Contato</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Informações</h5>
          <ul class="list-unstyled">
            <li>Telefone: 44 – 998453216</li>
            <li>Instagram: @med.exame</li>
            <li>CNPJ: 53.270.181/0001-32</li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Redes Sociais</h5>
          <ul class="list-unstyled d-flex">
            <li class="me-3"><a href="https://www.facebook.com/profile.php?id=100081021690578"><i class="fab fa-facebook fa-2x" style="color: #0D47A1;"></i></a></li>
            <li class="me-3"><a href="https://instagram.com/med.exame"><i class="fab fa-instagram fa-2x" style="color: #E1306C;"></i></a></li>
            <li class="me-3"><a href="https://wa.me/5544998453216"><i class="fab fa-whatsapp fa-2x" style="color: #25D366;"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-4">
        <small>© 2025 Medexame. Todos os direitos reservados.</small>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>