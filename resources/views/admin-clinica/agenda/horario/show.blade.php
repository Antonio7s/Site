@extends('layouts.painel-clinica')
@section('header_title', 'Horários do Médico')
@section('content')

<div class="card p-4">
    <h5>Horários de {{$profissional->profissional_nome}}</h5>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Duração</th>
            </tr>
        </thead>
        <tbody>
            @forelse($horarios as $horario)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($horario->data)->format('d/m/Y') }}</td>
                    <td>{{ $horario->horario_inicio }}</td>
                    <td>{{ $horario->duracao }} min</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhum horário cadastrado para este médico.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin-clinica.agenda.index') }}" class="btn btn-secondary">Voltar</a>
</div>

@endsection
