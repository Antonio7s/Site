@extends('layouts.painel-admin')
@section('header_title', 'Lucro') <!-- Alterando o h1 -->
@section('content')
    <div class="container mt-5">

        <!-- CORPO -->
        <div class="row mt-4">

            <div>
            <input type="text" class="form-control" placeholder="Pesquisar clínicas cadastradas">
            </div>

            <!-- Lista de Clínicas Cadastradas -->
            <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome da Clínica</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo 1 -->
                <tr>
                    <th scope="row">1</th>
                    <td>Clínica Saúde Total</td>
                    <td>12.345.678/0001-99</td>
                    <td>Rua Principal, 123, Centro</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Deletar</button>
                        <button class="btn btn-info btn-sm">Detalhes</button>
                    </td>
                </tr>
                <!-- Exemplo 2 -->
                <tr>
                    <th scope="row">2</th>
                    <td>Clínica Vida e Saúde</td>
                    <td>98.765.432/0001-11</td>
                    <td>Avenida Secundária, 456, Bairro Novo</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Deletar</button>
                        <button class="btn btn-info btn-sm">Detalhes</button>
                    </td>
                </tr>
                <!-- Exemplo 3 -->
                <tr>
                    <th scope="row">3</th>
                    <td>Clínica Bem Estar</td>
                    <td>23.456.789/0001-22</td>
                    <td>Praça Central, 789, Vila Antiga</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Deletar</button>
                        <button class="btn btn-info btn-sm">Detalhes</button>
                    </td>
                </tr>
            </tbody>
            </table>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Configuração de Percentual de Lucro</h5>
                        </div>
                        <div class="card-body">
                            <form id="formLucro">
                                <div class="mb-3">
                                    <label for="percentualLucro" class="form-label">Percentual de Lucro (%)</label>
                                    <input type="number" class="form-control" id="percentualLucro" placeholder="Digite o percentual de lucro" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection