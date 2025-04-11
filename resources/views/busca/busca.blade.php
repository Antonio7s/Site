@extends('layouts.layout-index')

@section('content')
    @php
        // Ordena os médicos para que aqueles que possuam procedimentos que contenham o termo pesquisado apareçam primeiro
        if(!empty($searchTerm)) {
            $medicos = $medicos->sortByDesc(function($medico) use ($searchTerm) {
                foreach($medico->procedimentos as $procedimento) {
                    if(stripos($procedimento->nome, $searchTerm) !== false) {
                        return 1;
                    }
                }
                return 0;
            });
        }
    @endphp

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
        /* Estilo para o dropdown de procedimentos */
        .dropdown-procedimentos {
            display: inline-block;
            position: relative;
        }
        .dropdown-toggle {
            cursor: pointer;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .dropdown-toggle:hover {
            background: #0056b3;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 110%;
            left: 0;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            z-index: 10;
            min-width: 150px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .dropdown-menu .procedure-item {
            padding: 5px 10px;
            cursor: pointer;
            color: black;
            text-decoration: underline;
        }
        .dropdown-menu .procedure-item:hover {
            background: #f4f4f4;
        }
        .procedure-item.active-procedure {
            font-weight: bold;
            color: darkblue;
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
            background-color: #e9f5f; /* Erro de digitação, se necessário corrigir para #e9f5ff */
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
            display: none; /* Inicialmente oculto */
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
        /* Estilos para as setas de navegação - inicialmente ocultas */
        .scroll-button {
            display: none;
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
                <input type="text" name="query" placeholder="Digite o termo pesquisado..." value="{{ $searchTerm }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <h1>Resultados da Busca</h1>
        <p>Buscando por: <strong>{{ $searchTerm }}</strong></p>
        @php
            $foundProcedure = false;
            if(!empty($searchTerm)) {
                foreach($medicos as $medico) {
                    if(isset($medico->procedimentos) && $medico->procedimentos->count() > 0) {
                        foreach($medico->procedimentos as $procedimento) {
                            if(stripos($procedimento->nome, $searchTerm) !== false) {
                                $foundProcedure = true;
                                break 2;
                            }
                        }
                    }
                }
            }
        @endphp
        @if(!empty($searchTerm) && !$foundProcedure)
            <p>Nenhum médico encontrado para "{{ $searchTerm }}".</p>
        @endif
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
                        <p>
                            <strong>Procedimentos:</strong>
                            @if(isset($medico->procedimentos) && $medico->procedimentos->count() > 0)
                                @php
                                    // Reordena os procedimentos: os que contêm o termo pesquisado aparecem primeiro
                                    $sortedProcedimentos = $medico->procedimentos;
                                    if(!empty($searchTerm)) {
                                        $matching = $medico->procedimentos->filter(function($proc) use ($searchTerm) {
                                            return stripos($proc->nome, $searchTerm) !== false;
                                        });
                                        $nonMatching = $medico->procedimentos->reject(function($proc) use ($searchTerm) {
                                            return stripos($proc->nome, $searchTerm) !== false;
                                        });
                                        $sortedProcedimentos = $matching->merge($nonMatching);
                                    }
                                @endphp
                                <div class="dropdown-procedimentos">
                                    <button type="button" class="dropdown-toggle" data-medico-id="{{ $medico->id }}">Selecione</button>
                                    <div class="dropdown-menu">
                                        @foreach($sortedProcedimentos as $procedimento)
                                            <div class="procedure-item" data-medico-id="{{ $medico->id }}" data-procedimento="{{ $procedimento->nome }}">
                                                {{ $procedimento->nome }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                Nenhum procedimento cadastrado
                            @endif
                        </p>
                        <p><strong>Clínica:</strong> {{ $medico->clinica_nome }}</p>
                        <p><strong>Endereço:</strong> {{ $medico->endereco }}</p>
                        <p><strong>Localização:</strong> {{ $medico->localizacao }}</p>
                    </div>
                    <div class="appointment-info">
                        <button type="button" class="btn-agendamento" data-medico-id="{{ $medico->id }}">Agendar</button>
                        @if(isset($medico->horarios) && $medico->horarios->count() > 0)
                            <div class="horarios-container-wrapper" style="display: none;">
                                <!-- Scroll buttons inicialmente ocultas; serão exibidas somente após clicar em "Agendar" -->
                                <button class="scroll-button left" onclick="scrollHorarios('left', {{ $medico->id }})">&#10094;</button>
                                <div class="horarios-container" id="horarios-container-{{ $medico->id }}">
                                    @php
                                        // Agrupa os horários por data
                                        $horariosAgrupados = $medico->horarios->groupBy('data');
                                    @endphp
                                    @foreach($horariosAgrupados as $data => $horarios)
                                        @php
                                            $date = \Carbon\Carbon::parse($data);
                                        @endphp
                                        @if($date->isToday() || $date->isFuture())
                                            <div class="dia-container">
                                                <div class="dia-header">
                                                    @php
                                                        $diaSemana = $date->isoFormat('ddd');
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
                                                    {{ $date->format('d/m') }}
                                                </div>
                                                <div class="horarios-dia">
                                                    @foreach($horarios as $slot)
                                                        <button class="hour-box {{ $slot->bloqueado ? 'disabled' : '' }}"
                                                                data-medico-id="{{ $medico->id }}"
                                                                data-slot="{{ $slot->horario_inicio }}"
                                                                data-date="{{ $slot->data }}"
                                                                data-horario-id="{{ $slot->horario_id }}"
                                                                data-especialidade="{{ $slot->especialidade }}"
                                                                data-valor="{{ $slot->valor }}"
                                                                {{ $slot->bloqueado ? 'disabled' : '' }}>
                                                            {{ \Carbon\Carbon::parse($slot->horario_inicio)->format('H:i') }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button class="scroll-button right" onclick="scrollHorarios('right', {{ $medico->id }})">&#10095;</button>
                            </div>
                        @else
                            <p>Sem horários disponíveis</p>
                        @endif
                        <div class="selected-date" id="selected-date-{{ $medico->id }}" style="display: none;"></div>
                        <button type="button" class="btn-confirmar" data-medico-id="{{ $medico->id }}" style="display:none;">Confirmar</button>
                    </div>
                </div>
            @endforeach
        @else
            <p>Nenhum médico encontrado.</p>
        @endif

        <!-- Paginação -->
        @if(isset($medicos) && method_exists($medicos, 'hasPages') && $medicos->hasPages())
            <div class="pagination">
                {{ $medicos->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown de procedimentos
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
                });
            });
            // Fecha o dropdown se clicar fora
            document.addEventListener('click', function () {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            });

            // Atualiza o texto do dropdown quando um procedimento é selecionado
            document.querySelectorAll('.procedure-item').forEach(item => {
                item.addEventListener('click', function () {
                    const medicoId = this.getAttribute('data-medico-id');
                    const procedureName = this.getAttribute('data-procedimento');
                    
                    // Atualiza o texto do botão do dropdown
                    const dropdownToggle = document.querySelector(`.dropdown-toggle[data-medico-id="${medicoId}"]`);
                    if (dropdownToggle) {
                        dropdownToggle.innerText = procedureName;
                    }
                    
                    // Se o item já estiver ativo, desativa e mostra todos os horários
                    if(this.classList.contains('active-procedure')){
                        document.querySelectorAll(`.hour-box[data-medico-id="${medicoId}"]`).forEach(box => {
                            box.style.display = '';
                        });
                        document.querySelectorAll(`.procedure-item[data-medico-id="${medicoId}"]`).forEach(el => {
                            el.classList.remove('active-procedure');
                        });
                    } else {
                        // Remove a classe ativa dos demais e ativa o atual
                        document.querySelectorAll(`.procedure-item[data-medico-id="${medicoId}"]`).forEach(el => {
                            el.classList.remove('active-procedure');
                        });
                        this.classList.add('active-procedure');

                        // Filtra os horários para mostrar somente os que correspondem ao procedimento selecionado
                        document.querySelectorAll(`.hour-box[data-medico-id="${medicoId}"]`).forEach(box => {
                            if(box.getAttribute('data-especialidade') === procedureName) {
                                box.style.display = '';
                            } else {
                                box.style.display = 'none';
                            }
                        });
                    }
                });
            });

            // Se houver um termo pesquisado, atualiza os dropdowns automaticamente, colocando primeiro os procedimentos que contenham o termo
            const searchTerm = "{{ $searchTerm }}".toLowerCase();
            if(searchTerm) {
                document.querySelectorAll('.dropdown-procedimentos').forEach(dropdown => {
                    const medicoId = dropdown.querySelector('.dropdown-toggle').getAttribute('data-medico-id');
                    let matching = [];
                    let nonMatching = [];
                    dropdown.querySelectorAll('.procedure-item').forEach(item => {
                        if(item.innerText.toLowerCase().includes(searchTerm)) {
                            matching.push(item.innerHTML);
                        } else {
                            nonMatching.push(item.innerHTML);
                        }
                    });
                    if(matching.length > 0) {
                        dropdown.querySelector('.dropdown-toggle').innerText = matching[0];
                    }
                });
            }

            // Alterna a exibição dos agendamentos e, ao clicar em "Agendar", exibe os botões de rolagem
            document.querySelectorAll('.btn-agendamento').forEach(button => {
                button.addEventListener('click', function () {
                    const agenda = this.nextElementSibling;
                    const appointmentInfo = this.parentElement;
                    if (!agenda.style.display || agenda.style.display === 'none') {
                        agenda.style.display = 'block';
                        // Exibe os botões de rolagem somente se houver horários
                        const leftButton = appointmentInfo.querySelector('.scroll-button.left');
                        const rightButton = appointmentInfo.querySelector('.scroll-button.right');
                        if(leftButton) leftButton.style.display = 'block';
                        if(rightButton) rightButton.style.display = 'block';
                    } else {
                        agenda.style.display = 'none';
                        // Oculta os botões de rolagem quando Agendar é fechado
                        const leftButton = appointmentInfo.querySelector('.scroll-button.left');
                        const rightButton = appointmentInfo.querySelector('.scroll-button.right');
                        if(leftButton) leftButton.style.display = 'none';
                        if(rightButton) rightButton.style.display = 'none';
                    }
                });
            });

            // Seleção dos horários e exibição dos detalhes do slot selecionado
            document.querySelectorAll('.hour-box').forEach(hourBox => {
                hourBox.addEventListener('click', function () {
                    const medicoId = this.getAttribute('data-medico-id');
                    const slotDate = this.getAttribute('data-date');
                    const procedimento = this.getAttribute('data-especialidade');
                    const valor = this.getAttribute('data-valor');

                    document.querySelectorAll(`.hour-box[data-medico-id="${medicoId}"]`).forEach(box => {
                        box.classList.remove('selected');
                    });
                    this.classList.add('selected');

                    const selectedDateElement = document.getElementById(`selected-date-${medicoId}`);
                    selectedDateElement.style.display = 'block';
                    selectedDateElement.innerHTML = `
                        <strong>Data selecionada:</strong> ${slotDate} <br>
                        <strong>Procedimento:</strong> ${procedimento} <br>
                        <strong>Valor:</strong> ${valor}
                    `;
                    const confirmButton = document.querySelector(`.btn-confirmar[data-medico-id="${medicoId}"]`);
                    confirmButton.style.display = 'inline-block';
                });
            });

            // Lógica para o botão "Confirmar"
            document.querySelectorAll('.btn-confirmar').forEach(button => {
                button.addEventListener('click', function () {
                    const medicoId = this.getAttribute('data-medico-id');
                    const selectedHour = document.querySelector(`.hour-box.selected[data-medico-id="${medicoId}"]`);
                    if (selectedHour) {
                        const horarioId = selectedHour.getAttribute('data-horario-id');
                        enviarHorario(horarioId);
                    } else {
                        alert('Por favor, selecione um horário antes de confirmar.');
                    }
                });
            });

            function enviarHorario(horarioId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("compra.index") }}';
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(tokenInput);
                const horarioIdInput = document.createElement('input');
                horarioIdInput.type = 'hidden';
                horarioIdInput.name = 'horario_id';
                horarioIdInput.value = horarioId;
                form.appendChild(horarioIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        });

        function scrollHorarios(direction, medicoId) {
            const container = document.getElementById(`horarios-container-${medicoId}`);
            const scrollAmount = 200;
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    </script>
@endsection
