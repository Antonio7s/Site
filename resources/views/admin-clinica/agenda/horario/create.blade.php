@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')
    <!-- Seção para definir o intervalo de horários (para criar horários) -->
    <div id="formHorarioSection" class="card p-4 mt-4">
        <!-- agenda id -->
        <input type="hidden" id="agendaId" value="{{ $agendaId }}">

        <h5>Definir Intervalo de Horários para <span id="doctorName"></span></h5>
        <form id="formHorario">
            <div class="mb-3">
                <label for="horaInicio" class="form-label">Horário de Início</label>
                <input type="time" class="form-control" id="horaInicio" required>
            </div>
            <div class="mb-3">
                <label for="horaFim" class="form-label">Horário de Fim</label>
                <input type="time" class="form-control" id="horaFim" required>
            </div>
            <div class="mb-3">
                <label for="duracao" class="form-label">Duração da Consulta (minutos)</label>
                <input type="number" class="form-control" id="duracao" min="5" required>
            </div>
            <div class="mb-3">
                <label for="datas" class="form-label">Datas</label>
                <input type="text" class="form-control" id="datas" placeholder="Selecione as datas" readonly required>
                <small class="form-text text-muted">Escolha múltiplas datas.</small>
            </div>

            <div class="accordion" id="procedimentosAccordion">
                @foreach ($profissional->procedimentos as $procedimento)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $procedimento->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $procedimento->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $procedimento->id }}">
                                <input type="checkbox" class="procedimento-checkbox me-2"
                                    id="procedimento{{ $procedimento->id }}"
                                    value="{{ $procedimento->id }}">
                                {{ $procedimento->nome }}
                            </button>
                        </h2>
                        <div id="collapse{{ $procedimento->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $procedimento->id }}" data-bs-parent="#procedimentosAccordion">
                            <div class="accordion-body">
                                <strong>Valor:</strong> R$ {{ number_format($procedimento->valor, 2, ',', '.') }}<br>
                                <strong>Classe ID:</strong> {{ $procedimento->classe_id }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <button type="button" class="btn btn-success" onclick="gerarHorarios()">Gerar Horários</button>
        </form>
    </div>

    <!-- Seção de Exibição de Horários -->
    <div id="horariosSection" class="mt-5" style="display: none;">
        <h4>Horários Gerados para <span id="doctorName2"></span></h4>
        
        <!-- Tabela de Horários -->
        <div id="horariosGrouped" class="mt-3"></div>
    </div>

    <!-- Modal de Calendário -->
    <div id="calendarModal" class="modal fade" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Selecione as Datas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="calendar"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="confirmDates">Confirmar Datas</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão Salvar Horários inicialmente oculto -->
    <a id="btnSalvarHorarios" href="javascript:void(0);" class="btn btn-primary" onclick="salvarHorarios()" style="display: none;">Salvar Horários</a>

    <!-- Carregar o Flatpickr e a folha de estilo CSS do Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Certifique-se de ter o token CSRF disponível -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // Variável global para armazenar os horários gerados
        let horariosGerados = [];

        // Inicializa o calendário para seleção de múltiplas datas
        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar(); // Chama a função para inicializar o Flatpickr
        });

        function initializeCalendar() {
            flatpickr("#datas", {
                mode: "multiple", 
                dateFormat: "Y-m-d", 
                onClose: function(selectedDates) {
                    document.getElementById('datas').value = selectedDates
                        .map(date => date.toISOString().split('T')[0])
                        .join(', ');
                }
            });
        }

        // Função que gera os horários e exibe-os na tela
        function gerarHorarios() {
            const horaInicio = document.getElementById('horaInicio').value;
            const horaFim = document.getElementById('horaFim').value;
            const duracao = parseInt(document.getElementById('duracao').value);
            const datas = document.getElementById('datas').value.split(',').map(data => data.trim());
            const agendaId = document.getElementById('agendaId').value; // Pega o id da agenda

            // Capturar o procedimento selecionado
            const procedimentoSelecionado = document.querySelector(".procedimento-checkbox:checked");
            if (!procedimentoSelecionado) {
                alert("Por favor, selecione um procedimento.");
                return;
            }
            const procedimentoId = procedimentoSelecionado.value; // ID do procedimento selecionado

            if (!horaInicio || !horaFim || !duracao || !datas.length) {
                alert("Por favor, preencha todos os campos corretamente.");
                return;
            }

            // Limpa os horários anteriores
            horariosGerados = [];

            // Gerar horários com base no intervalo de tempo para cada data
            datas.forEach(data => {
                let dataAtual = new Date(`${data}T${horaInicio}:00`);
                while (dataAtual < new Date(`${data}T${horaFim}:00`)) {
                    const fimConsulta = new Date(dataAtual.getTime() + duracao * 60000); // Duração em milissegundos
                    horariosGerados.push({
                        data: data,
                        //hora: dataAtual.toTimeString().slice(0, 5),
                        duracao: duracao,
                        inicio: dataAtual.toTimeString().slice(0, 5),  // Formato 'HH:MM'
                        fim: fimConsulta.toTimeString().slice(0, 5),     // Formato 'HH:MM'
                        agenda_id: agendaId,  // Adiciona o id da agenda
                        procedimento_id: procedimentoId // Adiciona o procedimento ao envio

                    });
                    dataAtual = fimConsulta; // Atualiza para o próximo horário
                }
            });

            // Agrupar os horários por data
            const groupedHorarios = groupByDate(horariosGerados);
            const groupedContainer = document.getElementById('horariosGrouped');
            groupedContainer.innerHTML = ''; // Limpar antes de exibir os dados

            // Exibir os horários agrupados por data
            for (const date in groupedHorarios) {
                const horariosPorData = groupedHorarios[date];
                const table = createTable(horariosPorData);
                groupedContainer.appendChild(createSection(date, table));
            }

            // Exibir a seção de horários e ocultar a seção de formulário
            document.getElementById('horariosSection').style.display = 'block';
            document.getElementById('formHorarioSection').style.display = 'none';

            // Exibe o botão "Salvar Horários"
            document.getElementById('btnSalvarHorarios').style.display = 'block';

            // Retorna os horários gerados (caso seja necessário)
            return horariosGerados;
        }

        // Função para agrupar os horários por data
        function groupByDate(horarios) {
            return horarios.reduce((acc, horario) => {
                if (!acc[horario.data]) {
                    acc[horario.data] = [];
                }
                acc[horario.data].push(horario);
                return acc;
            }, {});
        }

        // Função para criar a tabela para cada data
        function createTable(horarios) {
            const table = document.createElement('table');
            table.classList.add('table', 'table-striped', 'table-bordered');
            table.innerHTML = `
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    ${horarios.map(horario => `
                        <tr>
                            <td>${horario.inicio}</td>
                            <td>${horario.duracao}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editarHorario()">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="excluirHorario(this)">Excluir</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            `;
            return table;
        }

        // Função para criar uma seção para cada data
        function createSection(date, table) {
            const section = document.createElement('div');
            section.classList.add('mb-4');
            section.innerHTML = `<h5>${date}</h5>`;
            section.appendChild(table);
            return section;
        }

        // Função para excluir um horário
        function excluirHorario(button) {
            const row = button.closest('tr');
            row.remove();
        }

        // Função para editar um horário (exemplo simples de editar hora)
        function editarHorario() {
            alert('Editar horário (funcionalidade de exemplo)');
        }

        // Função para enviar os horários para o back-end via AJAX
        function salvarHorarios() {
            if (horariosGerados.length === 0) {
                alert("Não há horários para salvar. Gere os horários primeiro.");
                return;
            }

            fetch("{{ route('admin-clinica.agenda.horarios') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ horarios: horariosGerados })
            })
            .then(response => {
                if (response.status === 409) { // Conflito de horário duplicado
                    alert('Erro: Horário duplicado!');
                } else if (!response.ok) {
                    alert('Erro ao salvar horários!');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Sucesso: ' + data.message);
                    window.location.href = "{{ route('admin-clinica.agenda.index') }}";
                } else if (data.message) {
                    alert('Erro: ' + data.message); // Exibe mensagem de erro do servidor
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro de rede ao salvar horários');
            });
        }
    </script>
@endsection
