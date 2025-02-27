@extends('layouts.appusuarioautentificado')

@push('styles')
<style>
    .container {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th, .table-custom td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    .table-custom th {
        background-color: #f8f9fa;
    }
</style>
@endpush

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Meus Agendamentos</h2>

    @if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-bordered table-custom">
        <thead>
            <tr>
                <th>Nome de Agendamento</th>
                <th>Médico</th>
                <th>Procedimento</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Preço</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($pedidos) && $pedidos->isNotEmpty())
                @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->nome_agendamento ?? 'Não informado' }}</td>
                    <td>{{ $pedido->medico ?? 'Não informado' }}</td>
                    <td>{{ $pedido->procedimento ?? 'Não informado' }}</td>
                    <td>
                        @if($pedido->data)
                            {{ \Carbon\Carbon::parse($pedido->data)->format('d/m/Y') }}
                        @else
                            Não informado
                        @endif
                    </td>
                    <td>{{ $pedido->horario ?? 'Não informado' }}</td>
                    <td>
                        R$ {{ number_format($pedido->precos, 2, ',', '.') }}
                    </td>
                    <td>
                        @if($pedido->status == 'aguardando pagamento')
                            <span class="badge bg-warning text-dark">Aguardando Pagamento</span>
                        @elseif($pedido->status == 'confirmado')
                            <span class="badge bg-success">Confirmado</span>
                        @elseif($pedido->status == 'cancelado')
                            <span class="badge bg-danger">Cancelado</span>
                        @else
                            Não informado
                        @endif
                    </td>
                    <td>
                        @if($pedido->status == 'aguardando pagamento')
                        <form method="POST" action="">
                            @csrf
                            <input type="hidden" name="id" value="{{ $pedido->id }}">
                            <button type="submit" name="status" value="cancelado" class="btn btn-sm btn-danger">
                                Cancelar
                            </button>
                        </form>
                        @else
                        <span class="text-muted">Sem ações</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Nenhum agendamento disponível.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
