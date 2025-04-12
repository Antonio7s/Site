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
      background-color: white;
      transition: 0.3s;
      z-index: 1000;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
      color: #007bff;
    }
    .side-panel.open {
      left: 0;
    }
    .side-panel .panel-content {
      padding: 20px;
    }
    .side-panel .panel-title {
      font-size: 22px;
      margin-top: 30px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #007bff;
    }
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
    /* Centralizando os cards */
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
    /* Estilos para o status */
    .status-finalizado {
      color: green;
      font-weight: bold;
    }
    .status-andamento {
      color: orange;
      font-weight: bold;
    }
    /* Carrossel de Médicos em Destaque */
    .doctor-scroll-container {
      display: flex;
      overflow-x: auto;
      gap: 15px;
      padding-bottom: 10px;
    }
    .doctor-card {
      flex: 0 0 auto;
      width: 150px;
      text-align: center;
    }
    .doctor-card .doctor-image {
      width: 150px;
      height: 150px;
      border-radius: 8px;
      overflow: hidden;
      background: #eee;
    }
    .doctor-card .doctor-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
@endpush

@section('content')
  @php
    // Seleciona os 3 últimos agendamentos (ou quantos houver)
    $lastAppointments = $agendamentos->take(3);
    
    // Consulta todos os médicos do banco de dados.
    $allDoctors = \App\Models\Medico::all();
  @endphp
  <div class="centered-container">
    <!-- Card: Últimos Agendamentos -->
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        Últimos Agendamentos
      </div>
      <div class="card-body">
        @if(isset($lastAppointments) && $lastAppointments->isNotEmpty())
          <ul class="list-group">
            @foreach($lastAppointments as $agendamento)
              @php
                $appointmentDate = \Carbon\Carbon::parse($agendamento->data);
                $statusFinalizado = $appointmentDate->lte(\Carbon\Carbon::now());
                $statusText = $statusFinalizado ? 'Finalizado' : 'Em andamento';
                $statusClass = $statusFinalizado ? 'status-finalizado' : 'status-andamento';
              @endphp
              <li class="list-group-item">
                <strong>{{ $agendamento->clinica_nome ?? '--' }}</strong><br>
                <small class="text-muted">
                  Data: {{ $appointmentDate->format('d/m/Y H:i') }}
                </small><br>
                <span class="{{ $statusClass }}">
                  {{ $statusText }}
                </span>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-center text-muted">Nenhum agendamento recente.</p>
        @endif
      </div>
    </div>

    <!-- Card: Médicos em Destaque -->
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        Médicos em Destaque
      </div>
      <div class="card-body">
        <div class="doctor-scroll-container">
          @if(isset($allDoctors) && $allDoctors->isNotEmpty())
            @foreach($allDoctors as $doctor)
              <div class="doctor-card">
                <div class="doctor-image">
                  <img src="{{ $doctor->foto ? asset('storage/fotos_medicos/' . $doctor->foto) : asset('images/default_male.png') }}" 
                       alt="{{ $doctor->profissional_nome }} {{ $doctor->profissional_sobrenome }}">
                </div>
                <h5 style="margin-top: 10px;">
                  {{ $doctor->profissional_nome }} {{ $doctor->profissional_sobrenome }}
                </h5>
              </div>
            @endforeach
          @else
            <p class="text-center text-muted">Nenhum médico destacado.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Botão para abrir o painel lateral (sempre visível) -->
  <button class="toggle-btn" onclick="togglePanel()">&#9776; Menu</button>

  <!-- Painel lateral -->
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
