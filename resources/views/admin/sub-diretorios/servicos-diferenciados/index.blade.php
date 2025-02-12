@extends('layouts.painel-admin')
@section('header_title', 'Serviços diferenciados') <!-- Alterando o h1 -->
@section('content')

    <div class="container mt-5 ms-2">        
        <!-- Formulário de Cadastro -->

        <a href="{{ route('admin.servicos-diferenciados.create') }}" class="btn btn-primary">Adicionar Serviço</a>

        <!-- Tabela -->
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Clinica vinculada</th>
                    <th>Data Inicial</th>
                    <th>Data Final</th>
                    <th>Código</th>
                    <th>Procedimento</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Saúde em alta</td>
                    <td>15/07/2024</td>
                    <td>20/01/2025</td>
                    <td>10101012</td>
                    <td>CONSULTA MÉDICA</td>
                    <td>R$ 42,00</td>
                </tr>
                <tr>
                    <td>Saúde em alta</td>
                    <td>21/01/2025</td>
                    <td>-</td>
                    <td>10101012</td>
                    <td>CONSULTA MÉDICA</td>
                    <td>R$ 46,00</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection