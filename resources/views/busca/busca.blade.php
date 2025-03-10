@extends('layouts.layout-index')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 10px;
        }
        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .filter-select {
            background-color: #007bff;
            color: #fff;
            border: 2px solid #007bff;
            border-radius: 30px;
            padding: 10px;
            font-size: 16px;
            margin-right: 15px;
        }
        .search-bar input[type="text"] {
            padding: 12px 20px;
            font-size: 18px;
            width: 60%;
            border: 2px solid #007bff;
            border-radius: 30px;
            transition: border-color 0.3s ease;
            outline: none;
        }
        .search-bar input[type="text"]:focus {
            border-color: #0056b3;
        }
        .search-bar button {
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 18px;
            margin-left: 15px;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }
        .person-box {
            background-color: #fff;
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .person-photo {
            width: 120px;
            height: 120px;
            background-color: #ddd; /* Cor de fundo do quadrado sem foto */
            border-radius: 10px;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
        }
        .person-info {
            flex: 2;
        }
        .person-info h2 {
            margin: 0 0 10px;
            font-size: 24px;
            color: #333;
        }
        .person-info p {
            margin: 5px 0;
            color: #666;
        }
        .appointment-info {
            flex: 1;
            text-align: right;
        }
        .agenda {
            margin-bottom: 10px;
            display: none; /* Oculta os horários inicialmente */
        }
        .agenda.active {
            display: block; /* Exibe os horários quando ativo */
        }
        .agenda-date {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .horarios {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: flex-end;
        }
        .hour-box {
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #e9f5ff;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .hour-box.selected {
            background-color: #007bff;
            color: #fff;
        }
        .btn-agendamento {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        .btn-agendamento:hover {
            background-color: #218838;
        }
        .btn-agendamento:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>

    <div class="container">
        <!-- Formulário de busca -->
        <div class="search-bar">
            <form action="{{ route('index.inicial') }}" method="GET" style="display: flex; align-items: center; width: 100%;">
                <select class="filter-select" name="filter">
                    <option value="todos" {{ ($filter ?? 'todos') === 'todos' ? 'selected' : '' }}>Todos</option>
                    <option value="especialidade" {{ ($filter ?? 'todos') === 'especialidade' ? 'selected' : '' }}>Especialidade</option>
                    <option value="procedimentos" {{ ($filter ?? 'todos') === 'procedimentos' ? 'selected' : '' }}>Procedimentos</option>
                    <option value="profissional" {{ ($filter ?? 'todos') === 'profissional' ? 'selected' : '' }}>Nome do Profissional</option>
                    <option value="clinica" {{ ($filter ?? 'todos') === 'clinica' ? 'selected' : '' }}>Nome da Clínica</option>
                </select>
                <input type="text" name="query" placeholder="Digite o nome da pessoa..." value="{{ $searchTerm ?? '' }}" style="flex-grow: 1;">
                <button type="submit" style="margin-left: auto;">Buscar</button>
            </form>
        </div>

        <h1>Resultados da Busca</h1>
        <p>Buscando por: <strong>{{ $searchTerm ?? 'Nenhum termo pesquisado' }}</strong></p>
        <p>Filtro selecionado: <strong>{{ ucfirst($filter ?? 'todos') }}</strong></p>

        @if(isset($medicos) && !empty($searchTerm) && $medicos->isEmpty())
            <p>Nenhum médico encontrado para sua busca.</p>
            <h2>Outros Médicos:</h2>
            @if($fallbackMedicos->isNotEmpty())
                @foreach($fallbackMedicos as $medico)
                    <div class="person-box">
                        <div class="person-photo">Sem Foto</div> <!-- Quadrado sem foto -->
                        <div class="person-info">
                            <h2>{{ $medico->profissional_nome }} {{ $medico->profissional_sobrenome }}</h2>
                            <p><strong>Especialidade:</strong> {{ !empty($medico->medico_especialidade) ? $medico->medico_especialidade : '--' }}</p>
                            <p><strong>Clínica:</strong> {{ ($medico->clinica && !empty($medico->clinica->razao_social)) ? $medico->clinica->razao_social : 'Clínica Exemplo Ltda' }}</p>
                            <p><strong>Endereço:</strong> {{ !empty($medico->endereco) ? $medico->endereco : '--' }}</p>
                            <p>
                                <strong>Localização:</strong>
                                @if(!empty($medico->latitude) && !empty($medico->longitude))
                                    <a href="https://www.google.com/maps?q={{ $medico->latitude }},{{ $medico->longitude }}" target="_blank">Ver no Mapa</a>
                                @else
                                    Ver no Mapa
                                @endif
                            </p>
                        </div>
                        <div class="appointment-info">
                            <button type="button" class="btn-agendamento" data-medico-id="{{ $medico->id }}">Agendar</button>
                            @if(isset($medico->agendamentos) && $medico->agendamentos->count() > 0)
                                @foreach($medico->agendamentos as $agendamento)
                                    <div class="agenda">
                                        <p class="agenda-date">{{ $agendamento->data ?? '--' }}</p>
                                        <div class="horarios">
                                            @if(isset($agendamento->calculated_slots) && !empty($agendamento->calculated_slots))
                                                @foreach($agendamento->calculated_slots as $slot)
                                                    <button class="hour-box" data-medico-id="{{ $medico->id }}" data-slot="{{ $slot }}">{{ $slot }}</button>
                                                @endforeach
                                            @else
                                                <button class="hour-box" disabled>--</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Sem horários disponíveis</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p>Nenhum médico disponível.</p>
            @endif
        @else
            @if(isset($medicos) && $medicos->isNotEmpty())
                @foreach($medicos as $medico)
                    <div class="person-box">
                        <div class="person-photo">Sem Foto</div> <!-- Quadrado sem foto -->
                        <div class="person-info">
                            <h2>{{ $medico->profissional_nome }} {{ $medico->profissional_sobrenome }}</h2>
                            <p><strong>Especialidade:</strong> {{ !empty($medico->medico_especialidade) ? $medico->medico_especialidade : '--' }}</p>
                            <p><strong>Clínica:</strong> {{ ($medico->clinica && !empty($medico->clinica->razao_social)) ? $medico->clinica->razao_social : 'Clínica Exemplo Ltda' }}</p>
                            <p><strong>Endereço:</strong> {{ !empty($medico->endereco) ? $medico->endereco : '--' }}</p>
                            <p>
                                <strong>Localização:</strong>
                                @if(!empty($medico->latitude) && !empty($medico->longitude))
                                    <a href="https://www.google.com/maps?q={{ $medico->latitude }},{{ $medico->longitude }}" target="_blank">Ver no Mapa</a>
                                @else
                                    Ver no Mapa
                                @endif
                            </p>
                        </div>
                        <div class="appointment-info">
                            <button type="button" class="btn-agendamento" data-medico-id="{{ $medico->id }}">Agendar</button>
                            @if(isset($medico->agendamentos) && $medico->agendamentos->count() > 0)
                                @foreach($medico->agendamentos as $agendamento)
                                    <div class="agenda">
                                        <p class="agenda-date">{{ $agendamento->data ?? '--' }}</p>
                                        <div class="horarios">
                                            @if(isset($agendamento->calculated_slots) && !empty($agendamento->calculated_slots))
                                                @foreach($agendamento->calculated_slots as $slot)
                                                    <button class="hour-box" data-medico-id="{{ $medico->id }}" data-slot="{{ $slot }}">{{ $slot }}</button>
                                                @endforeach
                                            @else
                                                <button class="hour-box" disabled>--</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Sem horários disponíveis</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p>Nenhum dado disponível.</p>
            @endif
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Seleciona todos os botões de agendamento
            const agendamentoButtons = document.querySelectorAll('.btn-agendamento');

            agendamentoButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const medicoId = this.getAttribute('data-medico-id');
                    const agenda = this.nextElementSibling; // Seleciona o elemento .agenda

                    // Alterna a visibilidade dos horários
                    if (agenda.style.display === 'none' || !agenda.style.display) {
                        agenda.style.display = 'block';
                    } else {
                        agenda.style.display = 'none';
                    }
                });
            });

            // Seleciona todos os botões de horário
            const hourBoxes = document.querySelectorAll('.hour-box');

            hourBoxes.forEach(hourBox => {
                hourBox.addEventListener('click', function () {
                    // Remove a seleção de todos os horários do mesmo médico
                    const medicoId = this.getAttribute('data-medico-id');
                    document.querySelectorAll(`.hour-box[data-medico-id="${medicoId}"]`).forEach(box => {
                        box.classList.remove('selected');
                    });

                    // Marca o horário selecionado
                    this.classList.add('selected');
                });
            });
        });
    </script>
@endsection