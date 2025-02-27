@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Clínica Admin</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      margin-bottom: 20px;
    }
    .chart-container {
      padding: 20px;
    }
    .filter-group {
      margin-bottom: 20px;
    }
    #customDateFields {
      display: none;
    }
    /* Estilo para timeline na agenda dos médicos */
    .timeline {
      border-left: 2px solid #dee2e6;
      margin-left: 20px;
      padding-left: 10px;
    }
    .timeline-item {
      position: relative;
      margin-bottom: 15px;
    }
    .timeline-item::before {
      content: '';
      position: absolute;
      left: -11px;
      top: 0;
      width: 10px;
      height: 10px;
      background-color: #0d6efd;
      border-radius: 50%;
    }
  </style>
</head>
<body>

  <!-- Container Principal -->
  <div class="container">
    <!-- Filtro de Período -->
    <div class="card">
      <div class="card-header">
        Filtrar Período
      </div>
      <div class="card-body">
        <div class="filter-group">
          <div class="btn-group" role="group" aria-label="Filtro de período">
            <input type="radio" class="btn-check" name="filterOption" id="filterHoje" autocomplete="off" value="hoje" checked>
            <label class="btn btn-outline-primary" for="filterHoje">Hoje</label>
  
            <input type="radio" class="btn-check" name="filterOption" id="filterSemana" autocomplete="off" value="semana">
            <label class="btn btn-outline-primary" for="filterSemana">Esta Semana</label>
  
            <input type="radio" class="btn-check" name="filterOption" id="filterMes" autocomplete="off" value="mes">
            <label class="btn btn-outline-primary" for="filterMes">Este Mês</label>
  
            <input type="radio" class="btn-check" name="filterOption" id="filterCustom" autocomplete="off" value="custom">
            <label class="btn btn-outline-primary" for="filterCustom">Personalizado</label>
          </div>
        </div>
        <!-- Campos de data para filtro personalizado -->
        <div id="customDateFields" class="row">
          <div class="col-md-6">
            <label for="startDate" class="form-label">Data Início</label>
            <input type="date" class="form-control" id="startDate">
          </div>
          <div class="col-md-6">
            <label for="endDate" class="form-label">Data Fim</label>
            <input type="date" class="form-control" id="endDate">
          </div>
        </div>
        <!-- Botão para aplicar o filtro -->
        <div class="mt-3">
          <button class="btn btn-primary" onclick="applyFilter()">Aplicar Filtro</button>
        </div>
      </div>
    </div>

    <!-- Linha de Gráficos -->
    <div class="row">
      <!-- Gráfico de Agendamentos por Categoria -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Agendamentos por Categoria
          </div>
          <div class="card-body chart-container">
            <canvas id="categoryChart"></canvas>
          </div>
        </div>
      </div>
      <!-- Gráfico de Vendas / Agendamentos por Período -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Vendas / Agendamentos por Período
          </div>
          <div class="card-body chart-container">
            <canvas id="salesChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Agenda dos Médicos com Visualização Aprimorada -->
    <div class="card">
      <div class="card-header">
        Agenda dos Profissionais - <span id="dashboardDate"></span>
      </div>
      <div class="card-body">
        <div class="row" id="doctorsCards">
          <!-- Cards dos médicos serão inseridos via JavaScript -->
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle com Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script para atualizar o Dashboard -->
  <script>
    // Função para formatar data no padrão AAAA-MM-DD
    function formatDate(date) {
      return date.toISOString().split('T')[0];
    }

    // Data de hoje
    const hoje = new Date();
    const hojeStr = formatDate(hoje);
    document.getElementById('dashboardDate').innerText = hojeStr;

    // Dados padrão para "Hoje"
    let categoryDataHoje = [8, 5, 3, 4]; // Consultas, Exames, Checkup, Odontologia
    let salesDataHoje = {
      labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
      data: [2, 4, 3, 5, 2, 3]
    };

    // Dados da agenda dos médicos (exemplo)
    let doctorsAgendaHoje = [
      {
        medico: 'Dr. João',
        foto: 'https://via.placeholder.com/50',
        agenda: [
          { horario: '08:30', paciente: 'Ana Paula', status: 'Confirmado' },
          { horario: '10:00', paciente: 'Marcos Vinícius', status: 'Pendente' }
        ]
      },
      {
        medico: 'Dra. Maria',
        foto: 'https://via.placeholder.com/50',
        agenda: [
          { horario: '09:00', paciente: 'Carlos Silva', status: 'Confirmado' },
          { horario: '11:15', paciente: 'Beatriz Costa', status: 'Cancelado' },
          { horario: '13:00', paciente: 'Pedro Henrique', status: 'Confirmado' }
        ]
      },
      {
        medico: 'Dr. Pedro',
        foto: 'https://via.placeholder.com/50',
        agenda: [
          { horario: '08:45', paciente: 'Fernanda Souza', status: 'Confirmado' },
          { horario: '12:30', paciente: 'Rafael Lima', status: 'Pendente' }
        ]
      }
    ];

    // Variáveis para instâncias dos gráficos
    let categoryChart, salesChart;

    // Atualiza ou cria o gráfico de agendamentos por categoria
    function updateCategoryChart(data) {
      const ctx = document.getElementById('categoryChart').getContext('2d');
      if (categoryChart) {
        categoryChart.data.datasets[0].data = data;
        categoryChart.update();
      } else {
        categoryChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Consultas', 'Exames', 'Checkup', 'Odontologia'],
            datasets: [{
              label: 'Agendamentos',
              data: data,
              backgroundColor: [
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)'
              ],
              borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: { beginAtZero: true }
            }
          }
        });
      }
    }

    // Atualiza ou cria o gráfico de vendas/agendamentos por período
    function updateSalesChart(dataObj) {
      const ctx = document.getElementById('salesChart').getContext('2d');
      if (salesChart) {
        salesChart.data.labels = dataObj.labels;
        salesChart.data.datasets[0].data = dataObj.data;
        salesChart.update();
      } else {
        salesChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: dataObj.labels,
            datasets: [{
              label: 'Agendamentos',
              data: dataObj.data,
              fill: false,
              borderColor: 'rgba(255,99,132,1)',
              tension: 0.1
            }]
          },
          options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
          }
        });
      }
    }

    // Atualiza a visualização da agenda dos médicos usando cards e timeline
    function updateDoctorsCards(doctors) {
      const container = document.getElementById('doctorsCards');
      container.innerHTML = '';
      doctors.forEach(doc => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        const card = document.createElement('div');
        card.className = 'card h-100';
        
        // Cabeçalho do card com foto e nome do médico
        const cardHeader = document.createElement('div');
        cardHeader.className = 'card-header d-flex align-items-center';
        cardHeader.innerHTML = `<img src="${doc.foto}" alt="${doc.medico}" class="rounded-circle me-2" width="50" height="50">
                                <strong>${doc.medico}</strong>`;
        card.appendChild(cardHeader);
        
        // Corpo do card com timeline dos compromissos
        const cardBody = document.createElement('div');
        cardBody.className = 'card-body';
        const timeline = document.createElement('div');
        timeline.className = 'timeline';
        doc.agenda.forEach(apt => {
          const item = document.createElement('div');
          item.className = 'timeline-item';
          item.innerHTML = `<div>
                              <strong>${apt.horario}</strong> - ${apt.paciente} 
                              <span class="badge bg-${apt.status === 'Confirmado' ? 'success' : apt.status === 'Pendente' ? 'warning' : 'danger'}">${apt.status}</span>
                            </div>`;
          timeline.appendChild(item);
        });
        cardBody.appendChild(timeline);
        card.appendChild(cardBody);
        
        col.appendChild(card);
        container.appendChild(col);
      });
    }

    // Função para aplicar o filtro e atualizar o dashboard
    function applyFilter() {
      const filterValue = document.querySelector('input[name="filterOption"]:checked').value;
      let categoryData, salesData, doctorsData, dashboardLabel;

      // Simulação de dados conforme o filtro selecionado
      if(filterValue === 'hoje') {
        categoryData = categoryDataHoje;
        salesData = salesDataHoje;
        doctorsData = doctorsAgendaHoje;
        dashboardLabel = hojeStr;
      } else if(filterValue === 'semana') {
        categoryData = [40, 25, 20, 15];
        salesData = {
          labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
          data: [5, 6, 7, 8, 6, 4, 3]
        };
        doctorsData = doctorsAgendaHoje; // Exemplo: dados diferentes no backend
        dashboardLabel = 'Semana Atual';
      } else if(filterValue === 'mes') {
        categoryData = [160, 100, 80, 60];
        salesData = {
          labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
          data: [20, 25, 18, 22]
        };
        doctorsData = doctorsAgendaHoje;
        dashboardLabel = 'Mês Atual';
      } else if(filterValue === 'custom') {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        if (!start || !end) {
          alert('Selecione as duas datas para o filtro personalizado.');
          return;
        }
        categoryData = [10, 8, 6, 4];
        salesData = {
          labels: [start, '', end],
          data: [10, 15, 12]
        };
        doctorsData = doctorsAgendaHoje;
        dashboardLabel = `${start} a ${end}`;
      }

      // Atualiza gráficos e cards dos médicos
      updateCategoryChart(categoryData);
      updateSalesChart(salesData);
      updateDoctorsCards(doctorsData);
      document.getElementById('dashboardDate').innerText = dashboardLabel;
    }

    // Evento para exibir/esconder os campos de data quando "Personalizado" é selecionado
    document.querySelectorAll('input[name="filterOption"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.getElementById('customDateFields').style.display = (this.value === 'custom') ? 'flex' : 'none';
      });
    });

    // Inicializa o dashboard com os dados de hoje
    applyFilter();
  </script>
</body>
</html>


@endsection