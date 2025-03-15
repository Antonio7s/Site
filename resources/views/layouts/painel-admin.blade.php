<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ícones do Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <style>
    body {
      background-color: #f0f4f8;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      height: 100vh;
      background-color: #202044;
      color: #fff;
      padding: 20px;
      padding-bottom: 120px;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
      overflow-y: auto;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px;
      margin: 5px 0;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(5px);
    }
    .sidebar h3 {
      font-weight: bold;
      margin-bottom: 20px;
      color: #fff;
    }
    .main-content {
      padding: 20px;
      background-color: #f0f4f8;
    }
    .card {
      margin-bottom: 20px;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #fff;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #1a1a2e;
      color: #fff;
      border-radius: 10px 10px 0 0;
      padding: 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    .card-title {
      color: #1a1a2e;
      font-weight: bold;
    }
    .btn-primary {
      background-color: #1a1a2e;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #0f0f1a;
      transform: scale(1.05);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table {
      margin-top: 20px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      background-color: #fff;
    }
    .table thead {
      background-color: #1a1a2e;
      color: #fff;
    }
    .table th, .table td {
      padding: 12px;
      text-align: center;
    }
    .badge {
      padding: 8px 12px;
      border-radius: 20px;
      font-weight: bold;
    }
    .bg-success {
      background-color: #5cb85c !important;
    }
    .bg-warning {
      background-color: #f0ad4e !important;
    }
    .bg-danger {
      background-color: #d9534f !important;
    }
    h1, h2 {
      color: #1a1a2e;
      font-weight: bold;
    }
    .navbar {
      background-color: #1a1a2e;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      padding: 10px 20px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .navbar-brand {
      color: #fff;
      font-weight: bold;
    }
    .navbar .user-info {
      display: flex;
      align-items: center;
      margin-left: auto;
    }
    .navbar .user-info .notifications, .navbar .user-info .email {
      margin-right: 20px;
      position: relative;
      color: #fff;
      cursor: pointer;
    }
    .navbar .user-info .notifications .badge {
      position: absolute;
      top: -5px;
      right: -10px;
      background-color: #d9534f;
      color: #fff;
      font-size: 10px;
      padding: 3px 6px;
    }
    .navbar .user-info .profile {
      display: flex;
      align-items: center;
      cursor: pointer;
    }
    .navbar .user-info .profile img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .navbar .user-info .profile span {
      color: #fff;
    }
    .profile {
      position: relative;
    }
    #profile-dropdown {
      top: calc(100% + 5px);
      right: 0;
      left: auto;
      margin-top: 8px;
    }
    .title-container {
      background-color: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .dropdown-menu {
      display: none;
      position: absolute;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      padding: 10px;
      z-index: 1000;
    }
    .dropdown-menu.show {
      display: block;
    }
    .dropdown-menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .dropdown-menu ul li {
      padding: 8px 12px;
      cursor: pointer;
    }
    .dropdown-menu ul li:hover {
      background-color: #f0f4f8;
    }
    .sidebar::-webkit-scrollbar {
      width: 10px;
    }
    .sidebar::-webkit-scrollbar-track {
      background: #f0f4f8;
    }
    .sidebar::-webkit-scrollbar-thumb {
      background: #000000;
      border-radius: 5px;
    }
    .sidebar::-webkit-scrollbar-thumb:hover {
      background: #333;
    }

    /* Estilo personalizado para o botão hambúrguer */
    .navbar-toggler-custom {
      background: none;
      border: none;
      padding: 0;
      margin-right: 15px;
    }
    .navbar-toggler-custom .navbar-toggler-icon {
      width: 24px;
      height: 24px;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Ajuste do tamanho do Offcanvas */
    .offcanvas {
      width: 250px !important; /* Largura reduzida do Offcanvas */
    }

    /* Estilo para o card de mensagens */
    .message-card {
      position: absolute;
      top: 50px;
      right: 20px;
      width: 300px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 15px;
      z-index: 1000;
    }
    .message-card h5 {
      margin-bottom: 10px;
      font-weight: bold;
    }
    .message-card ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .message-card ul li {
      padding: 8px 0;
      border-bottom: 1px solid #f0f4f8;
    }
    .message-card ul li:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Painel Admin</a>
      <div class="user-info">
        <!-- Botão Hambúrguer personalizado -->
        <button class="navbar-toggler navbar-toggler-custom d-block d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="notifications" onclick="toggleMessageCard()">
          <i class="bi bi-bell"></i>
          <span class="badge">3</span>
        </div>
        <div class="email" onclick="toggleDropdown('email')">
          <i class="bi bi-envelope"></i>
          <div class="dropdown-menu" id="email-dropdown">
            <ul>
              <li>E-mail 1</li>
              <li>E-mail 2</li>
              <li>E-mail 3</li>
            </ul>
          </div>
        </div>
        <div class="profile" onclick="toggleDropdown('profile')">
          <span>{{ Auth::user()->name }}</span>
          <img src="{{ asset('images/icone-usuario.png') }}" alt="User Avatar">
          <div class="dropdown-menu" id="profile-dropdown">
            <ul>
              <li>Configurações</li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    Sair
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Card de Mensagens -->
  <div class="message-card" id="messageCard" style="display: none;">
    <h5>Mensagens:</h5>
    <ul>
      <li>Clínica A se cadastrou</li>
      <li>Clínica B se cadastrou</li>
      <li>Clínica C se cadastrou</li>
    </ul>
  </div>

  <!-- Offcanvas Sidebar -->
  <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="sidebar">
        <ul class="nav flex-column">
          <li><a href="{{ route('admin.dashboard.admin') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
          <li><a href="{{ route('admin.clinicas.index') }}"><i class="bi bi-building"></i> Clínicas</a></li>
          <li><a href="{{ route('admin.usuarios.index') }}"><i class="bi bi-people"></i> Usuários</a></li>
          <li><a href="{{ route('admin.especialidades.index') }}"><i class="bi bi-journal-medical"></i> Especialidades</a></li>
          <li><a href="{{ route('admin.classes.index') }}"><i class="bi bi-layers"></i> Classes</a></li>
          <li><a href="{{ route('admin.procedimentos.index') }}"><i class="bi bi-clipboard-pulse"></i> Procedimentos</a></li>
          <li><a href="{{ route('admin.servicos-diferenciados.index') }}"><i class="bi bi-cash-coin"></i> Servicos diferenciados</a></li>
          <!-- <li><a href="{{ route('admin.relatorios.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Relatórios</a></li> -->
          <li><a href="{{ route('admin.contatos.index') }}"><i class="bi bi-envelope"></i> Contatos</a></li>
          <li><a href="{{ route('admin.homepage.index') }}"><i class="bi bi-globe"></i> Homepage</a></li>
          <li><a href="#"><i class=""></i> Sistema de Pagamento</a></li>
          <!-- <li><a href="{{ route('admin.mensagens.index') }}"><i class="bi bi-chat-dots"></i> Mensagens</a></li> -->
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar (visível apenas em telas maiores) -->
      <div class="col-md-2 d-none d-md-block">
        <div class="sidebar">
          <h3>Menu</h3>
          <ul class="nav flex-column">
            <li><a href="{{ route('admin.dashboard.admin') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.clinicas.index') }}"><i class="bi bi-building"></i> Clínicas</a></li>
            <li><a href="{{ route('admin.usuarios.index') }}"><i class="bi bi-people"></i> Usuários</a></li>
            <li><a href="{{ route('admin.especialidades.index') }}"><i class="bi bi-journal-medical"></i> Especialidades</a></li>
            <li><a href="{{ route('admin.classes.index') }}"><i class="bi bi-layers"></i> Classes</a></li>
            <li><a href="{{ route('admin.procedimentos.index') }}"><i class="bi bi-clipboard-pulse"></i> Procedimentos</a></li>
            <li><a href="{{ route('admin.servicos-diferenciados.index') }}"><i class="bi bi-cash-coin"></i> Servicos diferenciados</a></li>
            <!-- <li><a href="{{ route('admin.relatorios.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Relatórios</a></li> -->
            <li><a href="{{ route('admin.contatos.index') }}"><i class="bi bi-envelope"></i> Contatos</a></li>
            <li><a href="{{ route('admin.homepage.index') }}"><i class="bi bi-globe"></i> Homepage</a></li>
            <li><a href="{{ route('admin.apikey.index') }}"> <i class=""></i> Sistema de Pagamento</a></li>
            <!-- <li><a href="{{ route('admin.mensagens.index') }}"><i class="bi bi-chat-dots"></i> Mensagens</a></li> -->
          </ul>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-12 col-md-10 main-content">
        <div class="title-container">
          <h1>@yield('header_title', 'Título Padrão')</h1>
        </div>
        <main>
          <div class="row mt-4">
            @yield('content')
          </div>
        </main>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  
  <!-- Script para interatividade -->
  <script>
    function toggleDropdown(id) {
      const dropdown = document.getElementById(`${id}-dropdown`);
      if (!dropdown) return;
      dropdown.classList.toggle('show');
    }

    function toggleMessageCard() {
      const messageCard = document.getElementById('messageCard');
      if (!messageCard) return;
      messageCard.style.display = messageCard.style.display === 'none' ? 'block' : 'none';
    }

    window.onclick = function(event) {
      if (!event.target.closest('.profile')) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
          dropdown.classList.remove('show');
        });
      }
      if (!event.target.closest('.notifications')) {
        const messageCard = document.getElementById('messageCard');
        if (messageCard) {
          messageCard.style.display = 'none';
        }
      }
    };
  </script>
</body>
</html>