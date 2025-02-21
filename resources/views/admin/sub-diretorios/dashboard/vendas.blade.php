@extends('layouts.painel-admin') <!-- Referencia o layout 'app.blade.php' -->
@section('header_title', 'Dashboard') <!-- Alterando o h1 -->

@section('content')
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Barra de Pesquisa -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar...">
                    </div>
                </div>

                <!-- Cards de Informações -->
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
                                <p class="card-text">{{ $totalClientes ?? 0 }}</p>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimas Vendas</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
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
                                        <tbody id="salesTable">
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

                <!-- Tabelas -->
                <div class="row mt-4">
                    <!-- Últimos Clientes Cadastrados -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimos Clientes Cadastrados</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Data de Cadastro</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentClientsTable">
                                            @if(isset($clientes) && $clientes->count() > 0)
                                                @foreach ($clientes as $cliente)
                                                    <tr>
                                                        <td>{{ $cliente->nome ?? 'N/A' }}</td>
                                                        <td>{{ $cliente->email ?? 'N/A' }}</td>
                                                        <td>{{ $cliente->created_at->format('d/m/Y') ?? 'N/A' }}</td>
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
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Localização</th>
                                                <th>Data de Cadastro</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentClinicsTable">
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
            // Função de pesquisa
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterTable('salesTable', searchTerm);
                filterTable('recentClientsTable', searchTerm);
                filterTable('recentClinicsTable', searchTerm);
            });

            function filterTable(tableId, searchTerm) {
                const table = document.getElementById(tableId);
                const rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) { // Começa de 1 para pular o cabeçalho
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent.toLowerCase();
                        if (cellText.includes(searchTerm)) {
                            found = true;
                            break;
                        }
                    }

                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
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
                            {{ $totalClientes ?? 0 }},
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
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            // Gráfico de Crescimento de Vendas
            var ctxGrowth = document.getElementById('salesGrowthChart').getContext('2d');
            var salesGrowthChart = new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
                    datasets: [
                        {
                            label: 'Vendas',
                            data: [{{ $vendasJaneiro ?? 0 }}, {{ $vendasFevereiro ?? 0 }}, {{ $vendasMarco ?? 0 }}, {{ $vendasAbril ?? 0 }}, {{ $vendasMaio ?? 0 }}, {{ $vendasJunho ?? 0 }}],
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </body>
@endsection