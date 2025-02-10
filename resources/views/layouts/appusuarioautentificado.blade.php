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
    /* Header */
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
    /* Footer */
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
  </style>
</head>
<body>
  <!-- Cabeçalho -->
  <header class="custom-header py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Logo e Links do header -->
      <div class="d-flex align-items-center">
        <!-- Logo -->
        <a href="{{ url('/privacy-policy') }}" class="me-3">
          <img src="/images/logo.png" alt="Minha Logo" style="height:40px;">
        </a>
        <!-- Links -->
        <a href="{{ url('/privacy-policy') }}" class="me-3">Políticas de Privacidade</a>
        <a href="{{ url('/about-medexames') }}">Sobre a Medexames</a>
      </div>
      <!-- Informações do usuário (ou links para login/cadastro) -->
      <div class="d-flex align-items-center">
        @auth
          <span class="me-2">{{ auth()->user()->name }}</span>
          <img src="{{ auth()->user()->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="{{ auth()->user()->name }}" class="rounded-circle" width="40" height="40">
        @else
          <a href="{{ url('/login') }}" class="me-2">Login</a>
          <a href="{{ url('/register') }}">Cadastro</a>
        @endauth
      </div>
    </div>
  </header>

  <!-- Offcanvas Sidebar (menu lateral que abre ao clicar) -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">Painel</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Página Inicial</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Meus Pedidos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Exames</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Endereços</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Pagamentos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Suporte</a></li>
        @auth
          <li class="nav-item mt-3">
            <form action="{{ url('/logout') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-danger w-100">Sair</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>

  <!-- Conteúdo Principal -->
  <div class="container my-4">
    <!-- Botão para abrir o menu lateral (visível em telas pequenas) -->
    <button class="btn btn-primary d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      Menu
    </button>
    <!-- Mensagem de boas-vindas (centralizada) -->
    @auth
      <div class="text-center mb-4">
        <h2>Olá, {{ auth()->user()->name }} 👋</h2>
      </div>
    @endauth

    <!-- Área de conteúdo que será preenchida pelas views filhas -->
    @yield('content')
  </div>

  <!-- Rodapé -->
  <footer class="custom-footer">
    <div class="container">
      <div class="row">
        <!-- Coluna Medexames -->
        <div class="col-md-4">
          <h5>Medexames</h5>
          <ul class="list-unstyled">
            <li><a href="{{ url('/about-medexames') }}">Sobre</a></li>
            <li><a href="{{ url('/privacy-policy') }}">Políticas de Privacidade</a></li>
            <li><a href="{{ url('/contact') }}">Contato</a></li>
          </ul>
        </div>
        <!-- Coluna Informações -->
        <div class="col-md-4">
          <h5>Informações</h5>
          <ul class="list-unstyled">
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Termos de Uso</a></li>
            <li><a href="#">Suporte</a></li>
          </ul>
        </div>
        <!-- Coluna Redes Sociais -->
        <div class="col-md-4">
          <h5>Redes Sociais</h5>
          <ul class="list-unstyled d-flex">
            <!-- Facebook com azul mais escuro -->
            <li class="me-3">
              <a href="#">
                <i class="fab fa-facebook fa-2x" style="color: #0D47A1;"></i>
              </a>
            </li>
            <!-- Instagram com sua cor característica -->
            <li class="me-3">
              <a href="#">
                <i class="fab fa-instagram fa-2x" style="color: #E1306C;"></i>
              </a>
            </li>
            <!-- Twitter em preto -->
            <li class="me-3">
              <a href="#">
                <i class="fab fa-twitter fa-2x" style="color: black;"></i>
              </a>
            </li>
            <!-- WhatsApp em verde -->
            <li class="me-3">
              <a href="#">
                <i class="fab fa-whatsapp fa-2x" style="color: #25D366;"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-4">
        <small>© 2025 Medexame. Todos os direitos reservados.</small>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
