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
    /* Timeline na agenda dos médicos */
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
        Agenda dos Profissionais - <span id="dashboardDate">{{ $hojeStr ?? date('Y-m-d') }}</span>
      </div>
      <div class="card-body">
        <div class="row" id="doctorsCards">
          <!-- Os cards dos médicos serão inseridos via JavaScript com os dados do banco -->
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle com Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Dados dinâmicos vindos do banco de dados (passados pelo controller) -->
  <script>
    let dashboardData = {
      hoje: {
        categoryData: @json($categoryDataHoje),
        salesData: @json($salesDataHoje), // Estrutura: { labels: [...], data: [...] }
        doctorsAgenda: @json($doctorsAgendaHoje),
        dashboardLabel: @json($hojeStr)
      },
      semana: {
        categoryData: @json($categoryDataSemana),
        salesData: @json($salesDataSemana),
        doctorsAgenda: @json($doctorsAgendaSemana),
        dashboardLabel: "Semana Atual"
      },
      mes: {
        categoryData: @json($categoryDataMes),
        salesData: @json($salesDataMes),
        doctorsAgenda: @json($doctorsAgendaMes),
        dashboardLabel: "Mês Atual"
      }
    };
  </script>

  <!-- Script para atualizar o Dashboard -->
  <script>
    let categoryChart, salesChart;

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

    function updateDoctorsCards(doctors) {
      const container = document.getElementById('doctorsCards');
      container.innerHTML = '';
      doctors.forEach(doc => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        const card = document.createElement('div');
        card.className = 'card h-100';
        
        // Cabeçalho com foto e nome do médico
        const cardHeader = document.createElement('div');
        cardHeader.className = 'card-header d-flex align-items-center';
        cardHeader.innerHTML = `<img src="${doc.foto}" alt="${doc.medico}" class="rounded-circle me-2" width="50" height="50">
                                <strong>${doc.medico}</strong>`;
        card.appendChild(cardHeader);
        
        // Corpo com timeline dos compromissos
        const cardBody = document.createElement('div');
        cardBody.className = 'card-body';
        const timeline = document.createElement('div');
        timeline.className = 'timeline';
        doc.agenda.forEach(apt => {
          const item = document.createElement('div');
          item.className = 'timeline-item';
          let badgeClass = 'secondary';
          if (apt.status === 'Confirmado') {
            badgeClass = 'success';
          } else if (apt.status === 'Pendente') {
            badgeClass = 'warning';
          } else if (apt.status === 'Cancelado') {
            badgeClass = 'danger';
          }
          item.innerHTML = `<div>
                              <strong>${apt.horario}</strong> - ${apt.paciente}
                              <span class="badge bg-${badgeClass}">${apt.status}</span>
                            </div>`;
          timeline.appendChild(item);
        });
        cardBody.appendChild(timeline);
        card.appendChild(cardBody);
        
        col.appendChild(card);
        container.appendChild(col);
      });
    }

    function applyFilter() {
      const filterValue = document.querySelector('input[name="filterOption"]:checked').value;
      if (filterValue === 'custom') {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        if (!start || !end) {
          alert('Selecione as duas datas para o filtro personalizado.');
          return;
        }
        // Requisição AJAX para dados personalizados (implemente o endpoint no controller)
        fetch(`/dashboard/custom?start=${start}&end=${end}`)
          .then(response => response.json())
          .then(data => {
            updateCategoryChart(data.categoryData);
            updateSalesChart(data.salesData);
            updateDoctorsCards(data.doctorsAgenda);
            document.getElementById('dashboardDate').innerText = data.dashboardLabel;
          })
          .catch(error => console.error(error));
      } else {
        let data = dashboardData[filterValue];
        updateCategoryChart(data.categoryData);
        updateSalesChart(data.salesData);
        updateDoctorsCards(data.doctorsAgenda);
        document.getElementById('dashboardDate').innerText = data.dashboardLabel;
      }
    }

    // Exibe ou oculta os campos para filtro personalizado
    document.querySelectorAll('input[name="filterOption"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.getElementById('customDateFields').style.display = (this.value === 'custom') ? 'flex' : 'none';
      });
    });

    // Inicializa o dashboard com os dados de "hoje"
    applyFilter();
  </script>
</body>
</html>
@endsection
