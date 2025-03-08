@extends('layouts.painel-admin')
@section('header_title', 'Serviços Diferenciados')
@section('content')

<div class="container mt-5 ms-2">        
    <!-- Botão para cadastrar novo serviço diferenciado -->
    <a href="{{ route('admin.servicos-diferenciados.create') }}" class="btn btn-primary">Adicionar Serviço</a>

    <!-- Tabela de listagem -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Clínica vinculada</th>
                <th>Data Inicial</th>
                <th>Data Final</th>
                <th>Código</th>
                <th>Procedimento</th>
                <th>Valor</th>
                <th>Ações</th> <!-- Nova coluna para ações -->
            </tr>
        </thead>
        <tbody>
            @forelse($clinicas as $clinica)
                @if($clinica->listaServicos->isNotEmpty())
                    @foreach($clinica->listaServicos as $servico)
                        <tr>
                            <td>{{ $clinica->razao_social }}</td>
                            <td>{{ $servico->data_inicial ?? '-' }}</td>
                            <td>{{ $servico->data_final ?? '-' }}</td>
                            <td>{{ $servico->codigo ?? '-' }}</td>
                            <td>{{ $servico->procedimento->nome }}</td>
                            <td>R$ {{ number_format($servico->preco_customizado, 2, ',', '.') }}</td>
                            <td>
                                <!-- Botões de ação -->
                                <a href="#" class="btn btn-info btn-sm">👁 Visualizar</a>
                                <a href="#" class="btn btn-warning btn-sm">✏ Editar</a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">🗑 Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @empty
                <tr>
                    <td colspan="7">Nenhuma clínica cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
