@extends('layouts.painel-clinica')
@section('header_title', 'Serviços Vinculados')
@section('content')

<div class="container mt-5 ms-2">        
    <!-- Tabela de listagem -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Data Inicial</th>
                <th>Data Final</th>
                <!-- <th>Código</th> -->
                <th>Procedimento</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicos as $servico)
                <tr>
                    <td>{{ $servico->data_inicial ?? '-' }}</td>
                    <td>{{ $servico->data_final ?? '-' }}</td>
                    <!-- <td>{{ $servico->codigo ?? '-' }}</td> -->
                    <!-- Verifique se o $servico é um objeto de serviço diferenciado ou um procedimento -->
                    <td>{{ isset($servico->procedimento) ? $servico->procedimento->nome : $servico->nome }}</td>
                    <td>R$ {{ number_format($servico->preco_customizado ?? $servico->valor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
