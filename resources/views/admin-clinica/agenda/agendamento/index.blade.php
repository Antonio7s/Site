@extends('layouts.painel-clinica')
@section('header_title', 'Agendamentos - ' . $profissional->profissional_nome)
@section('content')

<div class="container my-5">
    <h2>Agendamentos de {{ $profissional->profissional_nome }}</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Cliente</th>
                <th>Procedimento</th>
                <!-- <th>Valor</th> -->
                <th>Status</th>
                <!--<th>Ações</th> -->
            </tr>
        </thead>
        <tbody>
            @forelse($agendamentos as $agendamento)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($agendamento->data)) }}</td>
                    <td>{{ date('H:i', strtotime($agendamento->horario->horario_inicio)) }}</td>
                    <td>{{ $agendamento->user->name }}</td>
                    <td>{{ $agendamento->horario->procedimento->nome ?? 'N/A' }}</td>
                    <!-- <td>R$ {{ number_format($agendamento->horario->procedimento->valor ?? 0, 2, ',', '.') }}</td> -->
                    <td>{{ ucfirst($agendamento->status) }}</td>
                    <!-- <td>
                        <a href="#" class="btn btn-info btn-sm">Visualizar</a>
                        <a href="#" class="btn btn-warning btn-sm">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm">Cancelar</a>
                    </td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhum agendamento encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
