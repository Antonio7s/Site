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
      background-color: #f0f4f8; /* Fundo claro e suave */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      height: 100vh;
      background-color: #202044; /* Azul escuro para o menu */
      color: #fff;
      padding: 20px;
      padding-bottom: 120px; /* Adiciona um padding no final para garantir que os itens não fiquem muito próximos da borda */
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
      position: fixed; /* Fixa o menu lateral */
      width: 16.666667%; /* Largura da coluna do Bootstrap */
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
      background-color: rgba(255, 255, 255, 0.1); /* Efeito hover suave */
      transform: translateX(5px);
    }
    .sidebar h3 {
      font-weight: bold;
      margin-bottom: 20px;
      color: #fff;
    }
    .main-content {
      padding: 20px;
      background-color: #f0f4f8; /* Fundo claro */
      margin-left: 16.666667%; /* Compensa a largura do menu lateral */
    }
    .card {
      margin-bottom: 20px;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #fff; /* Fundo branco para os cards */
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #1a1a2e; /* Azul mais escuro para o cabeçalho do card */
      color: #fff;
      border-radius: 10px 10px 0 0;
      padding: 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    .card-title {
      color: #1a1a2e; /* Azul mais escuro para o título */
      font-weight: bold;
    }
    .btn-primary {
      background-color: #1a1a2e; /* Azul mais escuro para botões */
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #0f0f1a; /* Azul ainda mais escuro no hover */
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
      background-color: #1a1a2e; /* Azul mais escuro para o cabeçalho da tabela */
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
      background-color: #5cb85c !important; /* Verde suave */
    }
    .bg-warning {
      background-color: #f0ad4e !important; /* Laranja suave */
    }
    .bg-danger {
      background-color: #d9534f !important; /* Vermelho suave */
    }
    h1, h2 {
      color: #1a1a2e; /* Azul mais escuro para títulos */
      font-weight: bold;
    }
    .navbar {
      background-color: #1a1a2e; /* Azul mais escuro para a navbar */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      padding: 10px 20px;
      position: sticky; /* Fixa a navbar no topo */
      top: 0;
      z-index: 1000; /* Garante que a navbar fique acima de outros elementos */
    }
    .navbar-brand {
      color: #fff; /* Texto branco para o logo */
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
      color: #fff; /* Ícones brancos */
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
      color: #fff; /* Texto branco para o nome do usuário */
    }

    /* Ajuste de posicionamento do dropdown do perfil */
    .profile {
      position: relative; /* Adicionado para referência de posicionamento */
    }

    #profile-dropdown {
      top: calc(100% + 5px); /* Desce o dropdown 5px abaixo do elemento pai */
      right: 0; /* Mantém alinhado à direita */
      left: auto; /* Anula qualquer posicionamento à esquerda */
      margin-top: 8px; /* Adiciona um pequeno espaçamento */
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

    /* sidebar*/
    /* Estilo da barra de rolagem para navegadores WebKit (Chrome, Safari, Edge) */
    .sidebar::-webkit-scrollbar {
    width: 10px; /* Largura da barra de rolagem */
    }

    .sidebar::-webkit-scrollbar-track {
    background: #f0f4f8; /* Cor de fundo da área da barra de rolagem */
    }

    .sidebar::-webkit-scrollbar-thumb {
    background: #000000; /* Cor da barra de rolagem (preta) */
    border-radius: 5px; /* Bordas arredondadas */
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
    background: #333; /* Cor da barra de rolagem ao passar o mouse */
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Painel Admin</a>
      <div class="user-info">
        <div class="notifications" onclick="toggleDropdown('notifications')">
          <i class="bi bi-bell"></i>
          <span class="badge">3</span>
          <div class="dropdown-menu" id="notifications-dropdown">
            <ul>
              <li>Novo e-mail recebido</li>
              <li>Atualização do sistema</li>
              <li>Novo usuário cadastrado</li>
            </ul>
          </div>
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

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <h3>Menu</h3>
        <ul class="nav flex-column">
          <li><a href="{{ route('dashboard.admin') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
          <li><a href="{{ route('clinicas.index') }}"><i class="bi bi-building"></i> Clínicas</a></li>
          <li><a href="{{ route('usuarios.index') }}"><i class="bi bi-people"></i> Usuários</a></li>
          <!--<li><a href="#"><i class="bi bi-file-earmark-text"></i> Médicos</a></li> -->
          <li><a href="especialidades"><i class="bi bi-journal-medical"></i> Especialidades</a></li>
          <li><a href="classes"><i class="bi bi-layers"></i> Classes</a></li>
          <li><a href="procedimentos"><i class="bi bi-clipboard-pulse"></i> Procedimentos</a></li>
          <li><a href="servicos-diferenciados1"><i class="bi bi-cash-coin"></i> Servicos diferenciados</a></li>
          <!--<li><a href="#"><i class="bi bi-gear"></i> Agenda online</a></li> -->
          <li><a href="relatorios"><i class="bi bi-file-earmark-bar-graph"></i> Relatórios</a></li>
          <li><a href="contatos"><i class="bi bi-envelope"></i> Contatos</a></li>
          <li><a href="homepage"><i class="bi bi-globe"></i> Homepage</a></li>
          <li><a href="mensagens"><i class="bi bi-chat-dots"></i> Mensagens</a></li>
        </ul>
    </div>

      <!-- Main Content -->
      <div class="col-md-10 main-content">
        <div class="title-container">
          <h1>@yield('header_title', 'Título Padrão')</h1>
        </div>
        

            <!-- Conteúdo da página -->
            <main>
            <div class="row mt-4">
                @yield('content') <!-- Aqui será inserido o conteúdo da página -->
            </div>
            </main>
                
            </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  
  <!-- Script para interatividade -->
  <script>

    // Exibir Dropdown corretamente ao clicar no nome ou na foto
    function toggleDropdown(id) {
      const profileContainer = document.querySelector('.profile');
      const dropdown = document.getElementById(`${id}-dropdown`);

      if (!dropdown) return;

      // Alternar visibilidade do dropdown
      dropdown.classList.toggle('show');
    }

    // Fechar dropdowns ao clicar fora
    window.onclick = function(event) {
      if (!event.target.closest('.profile')) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
          dropdown.classList.remove('show');
        });
      }
    };


  </script>
</body>
</html>