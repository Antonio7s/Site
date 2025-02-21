@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')
    <!-- Seção para definir o intervalo de horários (para criar horários) -->
    <div id="formHorarioSection" class="card p-4 mt-4">
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

    <!-- Carregar o Flatpickr e a folha de estilo CSS do Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Inicializa o calendário para seleção de múltiplas datas
        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar(); // Chama a função para inicializar o Flatpickr
        });

        function initializeCalendar() {
            flatpickr("#datas", {
                mode: "multiple", 
                dateFormat: "Y-m-d", 
                onClose: function(selectedDates) {
                    document.getElementById('datas').value = selectedDates.map(date => date.toISOString().split('T')[0]).join(', ');
                }
            });
        }

        function gerarHorarios() {
            const horaInicio = document.getElementById('horaInicio').value;
            const horaFim = document.getElementById('horaFim').value;
            const duracao = parseInt(document.getElementById('duracao').value);
            const datas = document.getElementById('datas').value.split(',').map(data => data.trim());

            if (!horaInicio || !horaFim || !duracao || !datas.length) {
                alert("Por favor, preencha todos os campos corretamente.");
                return;
            }

            const horarios = [];
            let inicio = new Date(`2025-02-20T${horaInicio}:00`); // Data fixada para geração de horários
            const fim = new Date(`2025-02-20T${horaFim}:00`); // Fim do intervalo

            // Gerar horários com base no intervalo de tempo
            datas.forEach(data => {
                let dataAtual = new Date(`${data}T${horaInicio}:00`);
                while (dataAtual < new Date(`${data}T${horaFim}:00`)) {
                    const fimConsulta = new Date(dataAtual.getTime() + duracao * 60000); // Duração em milissegundos
                    horarios.push({
                        data: data,
                        hora: dataAtual.toTimeString().slice(0, 5),
                        duracao: `${duracao} minutos`,
                        inicio: dataAtual.toISOString(),
                        fim: fimConsulta.toISOString()
                    });
                    dataAtual = fimConsulta; // Atualiza para o próximo horário
                }
            });

            // Agrupar os horários por data
            const groupedHorarios = groupByDate(horarios);
            const groupedContainer = document.getElementById('horariosGrouped');
            groupedContainer.innerHTML = ''; // Limpar antes de exibir os dados

            // Exibir os horários agrupados por data
            for (const date in groupedHorarios) {
                const horariosPorData = groupedHorarios[date];
                const table = createTable(horariosPorData);
                groupedContainer.appendChild(createSection(date, table));
            }

            // Exibir a seção de horários e ocultar a seção de formulários
            document.getElementById('horariosSection').style.display = 'block';
            document.getElementById('formHorarioSection').style.display = 'none';
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
                            <td>${horario.hora}</td>
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
            section.innerHTML = `
                <h5>${date}</h5>
            `;
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
    </script>
@endsection
