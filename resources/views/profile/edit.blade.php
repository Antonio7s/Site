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
  </style>
@endpush

@section('content')
  <div class="row">
    <!-- Card: Últimos Pedidos -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          Últimos Pedidos
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
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          Exames
        </div>
        <div class="card-body">
          @if(isset($wishlist) && $wishlist->isNotEmpty())
            <div class="row g-3">
              @foreach($wishlist->take(2) as $item)
                <div class="col-12">
                  <div class="card">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="{{ $item->image ?? 'https://via.placeholder.com/150' }}" class="img-fluid rounded-start" alt="{{ $item->product_name }}">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title">{{ $item->product_name }}</h5>
                          <p class="card-text text-success">R$ {{ number_format($item->price, 2, ',', '.') }}</p>
                          <a href="#" class="btn btn-warning btn-sm">Comprar</a>
                        </div>
                      </div>
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
  </div>

  <!-- Card: Profissionais em Destaque -->
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          Profissionais em Destaque
        </div>
        <div class="card-body">
          <div class="row">
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
