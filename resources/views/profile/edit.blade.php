@extends('layouts.appusuarioautentificado') 

@push('styles')
  <style>
    .card {
      margin-bottom: 20px;
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

    /* Centralizar os cards */
    .centered-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      padding: 20px;
    }

    .centered-container .card {
      width: 100%;
      max-width: 600px;
    }

    /* Estilo para o status */
    .status-finalizado {
      color: green;
      font-weight: bold;
    }

    .status-andamento {
      color: orange;
      font-weight: bold;
    }
  </style>
@endpush

@section('content')
  <div class="centered-container">
    <!-- Card: Últimos Agendamentos -->
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        Últimos Agendamentos
      </div>
      <div class="card-body">
        @if(isset($ultimosAgendamentos) && $ultimosAgendamentos->isNotEmpty())
          <ul class="list-group">
            @foreach($ultimosAgendamentos as $agendamento)
              <li class="list-group-item">
                <strong>Agendamento #{{ $agendamento->id }}</strong><br>
                <small class="text-muted">Data: {{ $agendamento->data_agendamento->format('d/m/Y H:i') }}</small><br>
                <span class="{{ $agendamento->finalizado ? 'status-finalizado' : 'status-andamento' }}">
                  {{ $agendamento->finalizado ? 'Finalizado' : 'Em andamento' }}
                </span>
              </li>
            @endforeach
          </ul>
          <a href="#" class="btn btn-primary btn-sm mt-3">Ver todos</a>
        @else
          <p class="text-center text-muted">Nenhum agendamento recente.</p>
        @endif
      </div>
    </div>

    <!-- Card: Profissionais em Destaque -->
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        Profissionais em Destaque
      </div>
      <div class="card-body">
        <div class="row">
          @if(isset($recommendedProducts) && count($recommendedProducts))
            @foreach($recommendedProducts as $product)
              <div class="col-md-12">
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
