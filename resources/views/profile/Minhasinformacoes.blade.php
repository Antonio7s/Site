@extends('layouts.appusuarioautentificado')

@push('styles')
  <style>
    .profile-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 25px;
      background-color: #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .profile-card h3 {
      margin-bottom: 20px;
      font-size: 28px;
      color: #333;
      font-weight: 600;
    }

    .profile-card p {
      font-size: 18px;
      color: #555;
      margin-bottom: 15px;
    }

    .profile-card .btn {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 12px 25px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
      transition: background-color 0.3s ease;
    }

    .profile-card .btn:hover {
      background-color: #0056b3;
    }

    .profile-card .btn-secondary {
      background-color: #28a745;
    }

    .profile-card .btn-secondary:hover {
      background-color: #218838;
    }

    .profile-card .btn-warning {
      background-color: #ffc107;
    }

    .profile-card .btn-warning:hover {
      background-color: #e0a800;
    }

    .profile-card .btn-danger {
      background-color: #dc3545;
    }

    .profile-card .btn-danger:hover {
      background-color: #c82333;
    }

    .row {
      margin-top: 50px;
    }

    @media (max-width: 768px) {
      .profile-card {
        padding: 20px;
      }

      .profile-card h3 {
        font-size: 22px;
      }

      .profile-card p {
        font-size: 16px;
      }

      .profile-card .btn {
        padding: 10px 20px;
      }
    }

    /* Estilos para o painel lateral */
    .side-panel {
      position: fixed;
      top: 0;
      left: -250px;
      width: 250px;
      height: 100%;
      background-color: white; /* Fundo branco */
      transition: 0.3s;
      z-index: 1000;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
      color: #007bff; /* Cor do texto azul */
    }

    .side-panel.open {
      left: 0;
    }

    .side-panel .panel-content {
      padding: 20px;
    }

    /* Estilo do título "Painel" */
    .side-panel .panel-title {
      font-size: 22px;
      margin-top: 30px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #007bff;
    }

    /* Estilo para os links */
    .side-panel a {
      display: block;
      padding: 10px;
      color: #007bff;
      text-decoration: none;
      font-size: 16px;
      margin-bottom: 10px;
    }

    .side-panel a:hover {
      background-color: #f0f0f0;
    }

    /* Estilo do botão de menu */
    .toggle-btn {
      position: fixed;
      top: 15px;
      left: 15px;
      font-size: 16px;
      color: white;
      cursor: pointer;
      z-index: 1100;
      background-color: #007bff;
      border: none;
      border-radius: 8px;
      padding: 8px 12px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: background-color 0.3s ease;
    }

    .toggle-btn:hover {
      background-color: #0056b3;
    }

    .toggle-btn:focus {
      outline: none;
    }

    /* Estilo do botão Sair */
    .side-panel .btn-link {
      color: red !important;
      text-decoration: none;
      padding: 10px;
      margin-top: 10px;
      display: block;
      width: 100%;
      text-align: left;
      background: none;
      border: none;
      cursor: pointer;
    }

    .side-panel .btn-link:hover {
      background-color: #f0f0f0;
    }
  </style>
@endpush

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="profile-card">
          <h3>Minhas Informações</h3>
          <p><strong>Nome:</strong> {{ Auth::user()->name }}</p>
          <p><strong>E-mail:</strong> {{ Auth::user()->email }}</p>
          <p><strong>Data de Nascimento:</strong> {{ Auth::user()->data_nascimento ?? 'Não informado' }}</p>
          <p><strong>Telefone:</strong> {{ Auth::user()->telefone ?? 'Não informado' }}</p>
          
          <a href="{{ route('user.perfil.editar') }}" class="btn">Alterar Informações Básicas</a>
          <!-- <a href="#" class="btn btn-warning">Alterar E-mail</a> -->
          <a href="{{ route('user.mostrar.formulario.senha') }}" class="btn btn-danger">Alterar Senha</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Botão para abrir o painel lateral (sempre visível) -->
  <button class="toggle-btn" onclick="togglePanel()">&#9776; Menu</button>

  <!-- Painel lateral com apenas os itens solicitados -->
  <div class="side-panel" id="sidePanel">
    <div class="panel-content">
      <div class="panel-title">Painel</div>
      <a href="{{ url('/') }}">Página Inicial</a>
      <a href="{{ route('perfil.minhasInformacoes') }}">Minhas Informações</a>
      <a href="{{ url('perfil/meus-pedidos') }}">Meus Pedidos</a>
      
      <!-- Botão Sair (Logout) -->
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-link">Sair</button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function togglePanel() {
      const panel = document.getElementById('sidePanel');
      panel.classList.toggle('open');
    }
  </script>
@endpush