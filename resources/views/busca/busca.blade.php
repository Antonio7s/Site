@extends('layouts.layout-index')

@section('content')
    <style>
        /* Estilos CSS (mantidos iguais) */
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
            flex-wrap: wrap;
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
            flex-grow: 1;
            border: 2px solid #007bff;
            border-radius: 30px;
            transition: border-color 0.3s ease;
            outline: none;
            min-width: 200px;
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
            background-color: #ddd;
            border-radius: 10px;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
            flex-shrink: 0;
            overflow: hidden;
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
            display: none;
        }
        .agenda.active {
            display: block;
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
        .btn-confirmar {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }
        .btn-confirmar:hover {
            background-color: #0056b3;
        }
        .selected-date {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }
        /* Estilos responsivos */
        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-bar select,
            .search-bar input[type="text"],
            .search-bar button {
                width: 100%;
                margin: 5px 0;
            }
            .person-box {
                flex-direction: column;
                align-items: flex-start;
            }
            .appointment-info {
                text-align: left;
                margin-top: 10px;
                width: 100%;
            }
            .horarios {
                justify-content: flex-start;
            }
        }
        /* Estilos para paginação */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .pagination .page-item {
            margin: 0 1px;
        }
        .pagination .page-link {
            padding: 2px 8px;
            font-size: 20px;
            border: 1px solid #007bff;
            border-radius: 3px;
            color: #007bff;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .pagination .page-link:hover {
            background-color: #007bff;
            color: #fff;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            border-color: #dee2e6;
            pointer-events: none;
        }
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 16px;
            padding: 0 4px;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Novos estilos para exibição dos horários lado a lado */
        .horarios-container-wrapper {
            position: relative;
            width: 100%;
            max-width: 400px; /* Largura máxima para 3 dias */
            margin: 0 auto;
        }

        .horarios-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            overflow-x: hidden; /* Esconde o overflow */
            scroll-behavior: smooth; /* Rolagem suave */
        }

        .dia-container {
            border: 1px solid #007bff;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background-color: #f9f9f9;
            min-width: 120px; /* Largura mínima para cada dia */
            flex: 0 0 calc(33.33% - 10px); /* Exibe 3 dias por vez */
        }

        .dia-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dia-data {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }

        .horarios-dia {
            display: flex;
            flex-direction: column;
            gap: 5px;
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

        .hour-box.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Estilos para as setas de navegação */
        .scroll-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .scroll-button.left {
            left: -15px;
        }

        .scroll-button.right {
            right: -15px;
        }

        .scroll-button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container">
        <!-- Formulário de busca -->
        <div class="search-bar">
            <form action="{{ route('index.inicial') }}" method="GET" style="display: flex; align-items: center; width: 100%;">
                <select class="filter-select" name="filter">
                    <option value="todos" {{ ($filter ?? 'todos') === 'todos' ? 'selected' : '' }}>Todos</option>
                    <option value="procedimentos" {{ ($filter ?? 'todos') === 'procedimentos' ? 'selected' : '' }}>Procedimentos</option>
                    <option value="localizacao" {{ ($filter ?? 'todos') === 'localizacao' ? 'selected' : '' }}>Localização</option>
                    <option value="profissional" {{ ($filter ?? 'todos') === 'profissional' ? 'selected' : '' }}>Nome do Profissional</option>
                    <option value="clinica" {{ ($filter ?? 'todos') === 'clinica' ? 'selected' : '' }}>Nome da Clínica</option>
                </select>
                <input type="text" name="query" placeholder="Digite o termo de pesquisa..." value="{{ $searchTerm ?? '' }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <h1>Resultados da Busca</h1>
        <p>Buscando por: <strong>{{ $searchTerm ?? 'Nenhum termo pesquisado' }}</strong></p>
        <p>Filtro selecionado: <strong>{{ ucfirst($filter ?? 'todos') }}</strong></p>

        @if(isset($medicos) && $medicos->isNotEmpty())
            @foreach($medicos as $medico)
                <div class="person-box">
                    <div class="person-photo">
                        @if(!empty($medico->foto))
                            <img src="{{ $medico->foto }}" alt="{{ $medico->nome_completo }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                        @else
                            Sem Foto
                        @endif
                    </div>
                    <div class="person-info">
                        <h2>{{ $medico->nome_completo }}</h2>
                        <p><strong>Procedimentos:</strong> 
                            @if(isset($medico->procedimentos) && $medico->procedimentos->count() > 0)
                                @foreach($medico->procedimentos as $procedimento)
                                    {{ $procedimento->nome }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            @else
                                Nenhum procedimento cadastrado
                            @endif
                        </p>
                        <p><strong>Clínica:</strong> {{ $medico->clinica_nome }}</p>
                        <p><strong>Endereço:</strong> {{ $medico->endereco }}</p>
                        <p><strong>Localização:</strong> {{ $medico->localizacao }}</p>
                        <p><strong>Valor:</strong> {{ $medico->valor }}</p>
                    </div>
                    <div class="appointment-info">
                        <button type="button" class="btn-agendamento" data-medico-id="{{ $medico->id }}">Agendar</button>
                        @if(isset($medico->horarios) && $medico->horarios->count() > 0)
                            <div class="horarios-container-wrapper">
                                <button class="scroll-button left" onclick="scrollHorarios('left', {{ $medico->id }})">&#10094;</button>
                                <div class="horarios-container" id="horarios-container-{{ $medico->id }}">
                                    @php
                                        // Agrupa os horários por data
                                        $horariosAgrupados = $medico->horarios->groupBy('data');
                                    @endphp

                                    @foreach($horariosAgrupados as $data => $horarios)
                                        <div class="dia-container">
                                            <div class="dia-header">
                                                @php
                                                    $diaSemana = \Carbon\Carbon::parse($data)->isoFormat('ddd');
                                                    $diaSemanaPt = [
                                                        'Mon' => 'Seg',
                                                        'Tue' => 'Ter',
                                                        'Wed' => 'Qua',
                                                        'Thu' => 'Qui',
                                                        'Fri' => 'Sex',
                                                        'Sat' => 'Sáb',
                                                        'Sun' => 'Dom'
                                                    ][$diaSemana];
                                                @endphp
                                                {{ $diaSemanaPt }}
                                            </div>
                                            <div class="dia-data">
                                                {{ \Carbon\Carbon::parse($data)->format('d/m') }}
                                            </div>
                                            <div class="horarios-dia">
                                                @foreach($horarios as $slot)
                                                    <button class="hour-box {{ $slot->bloqueado ? 'disabled' : '' }}" data-medico-id="{{ $medico->id }}" data-slot="{{ $slot->horario_inicio }}" data-date="{{ $slot->data }}" {{ $slot->bloqueado ? 'disabled' : '' }}>
                                                        {{ \Carbon\Carbon::parse($slot->horario_inicio)->format('H:i') }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="scroll-button right" onclick="scrollHorarios('right', {{ $medico->id }})">&#10095;</button>
                            </div>
                        @else
                            <p>Sem horários disponíveis</p>
                        @endif
                        <div class="selected-date" id="selected-date-{{ $medico->id }}" style="display: none;">
                            <strong>Data selecionada:</strong> <span id="date-{{ $medico->id }}"></span>
                        </div>
                        <button type="button" class="btn-confirmar" data-medico-id="{{ $medico->id }}" style="display:none;">Confirmar</button>
                    </div>
                </div>
            @endforeach
        @else
            <p>Nenhum médico encontrado.</p>
        @endif

        <!-- Paginação -->
        @if(isset($medicos) && $medicos->hasPages())
            <div class="pagination">
                {{ $medicos->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Alterna a exibição dos agendamentos
            const agendamentoButtons = document.querySelectorAll('.btn-agendamento');
            agendamentoButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const agenda = this.nextElementSibling;
                    agenda.style.display = (!agenda.style.display || agenda.style.display === 'none') ? 'block' : 'none';
                });
            });

            // Seleção dos horários e exibição da data
            const hourBoxes = document.querySelectorAll('.hour-box');
            hourBoxes.forEach(hourBox => {
                hourBox.addEventListener('click', function () {
                    const medicoId = this.getAttribute('data-medico-id');
                    const slotDate = this.getAttribute('data-date');

                    // Remove a seleção de todos os horários do mesmo médico
                    document.querySelectorAll(`.hour-box[data-medico-id="${medicoId}"]`).forEach(box => {
                        box.classList.remove('selected');
                    });

                    // Adiciona a classe 'selected' ao horário clicado
                    this.classList.add('selected');

                    // Exibe a data do slot selecionado
                    const selectedDateElement = document.getElementById(`selected-date-${medicoId}`);
                    const dateElement = document.getElementById(`date-${medicoId}`);
                    selectedDateElement.style.display = 'block';
                    dateElement.textContent = slotDate;

                    // Exibe o botão "Confirmar" para o médico correspondente
                    const confirmButton = document.querySelector(`.btn-confirmar[data-medico-id="${medicoId}"]`);
                    confirmButton.style.display = 'inline-block';
                });
            });

            // Lógica para o botão "Confirmar"
            const confirmButtons = document.querySelectorAll('.btn-confirmar');
            confirmButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const medicoId = this.getAttribute('data-medico-id');
                    const selectedHour = document.querySelector(`.hour-box.selected[data-medico-id="${medicoId}"]`);
                    if (selectedHour) {
                        const slot = selectedHour.getAttribute('data-slot');
                        const slotDate = selectedHour.getAttribute('data-date');
                        alert(`Horário confirmado: ${slot} - Data: ${slotDate} para o médico ID ${medicoId}`);
                        // Aqui você pode adicionar a lógica para confirmar o agendamento
                    } else {
                        alert('Por favor, selecione um horário antes de confirmar.');
                    }
                });
            });
        });

        // Função para rolar os horários
        function scrollHorarios(direction, medicoId) {
            const container = document.getElementById(`horarios-container-${medicoId}`);
            const scrollAmount = 200; // Quantidade de rolagem
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    </script>
@endsection