@extends('layouts.layout-index')

@push('styles')
  <style>
    /* Container geral */
    .container {
      max-width: 900px;
      margin: 20px auto;
      padding: 10px;
    }
    /* Área de Pesquisa */
    .search-area {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
      gap: 10px;
    }
    .search-area form {
      display: flex;
      width: 100%;
      max-width: 800px;
      gap: 10px;
      align-items: center;
    }
    /* Dropdown customizado (verde e pequeno) */
    .filter-dropdown {
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 8px;
      font-size: 14px;
      width: 140px;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }
    .filter-dropdown option {
      color: black;
    }
    /* Campo de pesquisa */
    .search-input {
      flex: 1;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    /* Botão de pesquisa */
    .search-btn {
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
    /* Exibição da consulta realizada */
    .search-query {
      text-align: center;
      margin-bottom: 20px;
      font-size: 18px;
      color: #333;
    }
    /* Cards dos médicos */
    .doctor-card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    .doctor-card h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 10px;
    }
    .doctor-card p {
      color: #555;
      margin: 5px 0;
      line-height: 1.5;
    }
    .doctor-card a {
      color: #007bff;
      text-decoration: none;
    }
    .doctor-card a:hover {
      text-decoration: underline;
    }
    /* Agenda do Médico */
    .agenda {
      margin-top: 15px;
    }
    .agenda h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }
    .date-picker {
      margin-bottom: 10px;
    }
    .date-picker input[type="date"] {
      padding: 6px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .schedule {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }
    .hour {
      background-color: #e1f5fe;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .hour:hover {
      background-color: #81d4fa;
    }
    .save-btn {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
@endpush

@section('content')
  <div class="container">
    <!-- Área de Pesquisa com Dropdown -->
    <div class="search-area">
      <form action="{{ url()->current() }}" method="GET">
        <select name="filter" class="filter-dropdown">
          <option value="todos" selected>Todos</option>
          <option value="distancia">Distância</option>
          <option value="especialidade">Especialidade</option>
          <option value="procedimentos">Procedimentos</option>
          <option value="profissional">Nome do Profissional</option>
          <option value="clinica">Nome da Clínica</option>
        </select>
        <input type="text" name="query" class="search-input" placeholder="Digite sua pesquisa...">
        <button type="submit" class="search-btn">Pesquisar</button>
      </form>
    </div>

    <!-- Exibição da pesquisa realizada -->
    @if(request('query'))
      <div class="search-query">
        Você Buscou por: <strong>{{ request('query') }}</strong>
      </div>
    @endif

    <!-- Cards dos médicos vindos do banco de dados -->
    @if(isset($medicos) && count($medicos))
      @foreach($medicos as $medico)
        <div class="doctor-card">
          <h2>{{ $medico->nome ?? '--' }}</h2>
          <p><strong>Especialidade:</strong> {{ $medico->especialidade ?? '--' }}</p>
          <p><strong>Clínica:</strong> {{ $medico->clinica ?? '--' }}</p>
          <p><strong>Endereço:</strong> {{ $medico->endereco ?? '--' }}</p>
          <p>
            <strong>Localização:</strong>
            @if(!empty($medico->latitude) && !empty($medico->longitude))
              <a href="https://www.google.com/maps?q={{ $medico->latitude }},{{ $medico->longitude }}" target="_blank">Ver no Mapa</a>
            @else
              --
            @endif
          </p>
          <p><strong>Valor:</strong> R$ {{ !empty($medico->valor) ? number_format($medico->valor, 2, ',', '.') : '--' }}</p>
          <p><strong>Avaliação:</strong> {{ $medico->avaliacao ?? '--' }}</p>

          <!-- Agenda do Médico -->
          <div class="agenda">
            <h3>Horário</h3>
            <div class="date-picker">
              <input type="date" id="date-input-{{ $medico->id }}" onchange="updateDate({{ $medico->id }})">
              <p><strong>Data:</strong> <span id="selected-date-{{ $medico->id }}">03/02/2025</span></p>
            </div>
            <div class="schedule">
              @if(!empty($medico->horarios))
                @foreach($medico->horarios as $horario)
                  <div class="hour" onclick="selectHour({{ $medico->id }}, '{{ $horario }}')">
                    {{ $horario }}
                  </div>
                @endforeach
              @else
                <p>Sem horários disponíveis</p>
              @endif
            </div>
            <button class="save-btn" onclick="saveSchedule({{ $medico->id }})">Salvar Horário</button>
          </div>
        </div>
      @endforeach
    @else
      <p class="search-query">Nenhum médico encontrado.</p>
    @endif
  </div>

  @push('scripts')
    <script>
      // Atualiza a data selecionada para cada médico
      function updateDate(id) {
        const dateInput = document.getElementById('date-input-' + id);
        const selectedDate = document.getElementById('selected-date-' + id);
        selectedDate.textContent = dateInput.value.split('-').reverse().join('/');
      }
      // Armazena o horário selecionado para cada médico
      let selectedHours = {};
      function selectHour(id, hour) {
        selectedHours[id] = hour;
        alert(`Horário selecionado: ${hour}`);
      }
      function saveSchedule(id) {
        const date = document.getElementById('date-input-' + id).value;
        const hour = selectedHours[id];
        if (date && hour) {
          alert(`Horário salvo: ${date} às ${hour}`);
        } else {
          alert('Por favor, selecione uma data e um horário.');
        }
      }
    </script>
  @endpush
@endsection
