@extends('layouts.painel-admin')  
@section('header_title', 'Dashboard')

@section('content')
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Barra de Pesquisa com botão -->
                <div class="row mb-4">
                    <div class="col-md-10">
                        <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar...">
                    </div>
                    <div class="col-md-2">
                        <button id="searchButton" class="btn btn-primary btn-block">Pesquisar</button>
                    </div>
                </div>

                <!-- Cards de Informações Principais -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total de Vendas</h5>
                                <p class="card-text">{{ $totalVendas ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total de Clientes</h5>
                                <p class="card-text">{{ $totalUsuarios ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total de Clínicas</h5>
                                <p class="card-text">{{ $totalClinicas ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cards Extras com Dados -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Classes</h5>
                                <p class="card-text">{{ $totalClasses ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Procedimentos</h5>
                                <p class="card-text">{{ $totalProcedimentos ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Horário</h5>
                                <p class="card-text">{{ $totalHorarios ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Agendamento</h5>
                                <p class="card-text">{{ $totalAgendamentos ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Distribuição de Vendas por Categoria</h5>
                                <canvas id="salesDistributionChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Crescimento de Vendas</h5>
                                <canvas id="salesGrowthChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabelas -->
                <div class="row mt-4">
                    <!-- Tabela de Últimas Vendas -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimas Vendas</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="salesTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo</th>
                                                <th>Descrição</th>
                                                <th>Clínica</th>
                                                <th>Paciente</th>
                                                <th>Data</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($vendas) && $vendas->count() > 0)
                                                @foreach ($vendas as $venda)
                                                    <tr>
                                                        <td>{{ $venda->id ?? 'N/A' }}</td>
                                                        <td>{{ $venda->tipo ?? 'N/A' }}</td>
                                                        <td>{{ $venda->descricao ?? 'N/A' }}</td>
                                                        <td>{{ $venda->clinica->nome ?? 'N/A' }}</td>
                                                        <td>{{ $venda->paciente->nome ?? 'N/A' }}</td>
                                                        <td>{{ $venda->data ?? 'N/A' }}</td>
                                                        <td>R$ {{ number_format($venda->valor ?? 0, 2, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">Nenhuma venda encontrada.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabelas de Clientes e Clínicas -->
                <div class="row mt-4">
                    <!-- Últimos Clientes Cadastrados -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimos Clientes Cadastrados</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="recentClientsTable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Data de Cadastro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($usuarios) && $usuarios->count() > 0)
                                                @foreach ($usuarios as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario->nome ?? 'N/A' }}</td>
                                                        <td>{{ $usuario->email ?? 'N/A' }}</td>
                                                        <td>{{ $usuario->created_at->format('d/m/Y') ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">Nenhum cliente encontrado.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Últimas Clínicas Cadastradas -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimas Clínicas Cadastradas</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="recentClinicsTable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Localização</th>
                                                <th>Data de Cadastro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($clinicas) && $clinicas->count() > 0)
                                                @foreach ($clinicas as $clinica)
                                                    <tr>
                                                        <td>{{ $clinica->nome ?? 'N/A' }}</td>
                                                        <td>{{ $clinica->localizacao ?? 'N/A' }}</td>
                                                        <td>{{ $clinica->created_at->format('d/m/Y') ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">Nenhuma clínica encontrada.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS e dependências -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <!-- Chart.js para gráficos -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Função de pesquisa que filtra os dados de cada tabela
            function filterAllTables() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const tableIds = ['salesTable', 'recentClientsTable', 'recentClinicsTable'];
                tableIds.forEach(function(id) {
                    filterTable(id, searchTerm);
                });
            }

            // Evento para o botão "Pesquisar"
            document.getElementById('searchButton').addEventListener('click', function() {
                filterAllTables();
            });

            // Função que filtra uma tabela pelo termo pesquisado
            function filterTable(tableId, searchTerm) {
                const table = document.getElementById(tableId);
                if (table) {
                    const rows = table.getElementsByTagName('tr');
                    for (let i = 1; i < rows.length; i++) {
                        let row = rows[i];
                        let rowText = row.textContent.toLowerCase();
                        row.style.display = rowText.includes(searchTerm) ? '' : 'none';
                    }
                }
            }

            // Gráfico de Distribuição de Vendas por Categoria
            var ctxDistribution = document.getElementById('salesDistributionChart').getContext('2d');
            var salesDistributionChart = new Chart(ctxDistribution, {
                type: 'pie',
                data: {
                    labels: ['Vendas', 'Clientes', 'Clínicas'],
                    datasets: [{
                        label: 'Distribuição',
                        data: [
                            {{ $totalVendas ?? 0 }},
                            {{ $totalUsuarios ?? 0 }},
                            {{ $totalClinicas ?? 0 }}
                        ],
                        backgroundColor: [
                            'rgba(0, 123, 255, 0.6)',
                            'rgba(40, 167, 69, 0.6)',
                            'rgba(255, 193, 7, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } }
                }
            });

            // Gráfico de Crescimento de Vendas
            var ctxGrowth = document.getElementById('salesGrowthChart').getContext('2d');
            var salesGrowthChart = new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
                    datasets: [{
                        label: 'Vendas',
                        data: [
                            {{ $vendasJaneiro ?? 0 }},
                            {{ $vendasFevereiro ?? 0 }},
                            {{ $vendasMarco ?? 0 }},
                            {{ $vendasAbril ?? 0 }},
                            {{ $vendasMaio ?? 0 }},
                            {{ $vendasJunho ?? 0 }}
                        ],
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    </body>
@endsection
