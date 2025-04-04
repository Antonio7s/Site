@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <!-- Lista de profissionais -->

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome do Médico</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($profissionais as $profissional)
                <tr>
                    <td>{{$profissional->profissional_nome}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Ações">
                            <a href="{{ route('admin-clinica.agenda.agendamento.index', $profissional->id) }}" class="btn btn-info btn-sm">Ver Agendamentos</a>
                            <a href="{{ route('admin-clinica.agenda.horario.show', $profissional->id)  }}" class="btn btn-primary btn-sm">Ver Horários</a>
                            <a href="{{ route('admin-clinica.agenda.horario.create', $profissional->id) }}" class="btn btn-success btn-sm">Criar Horário</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Não há registro de classes</td>
                </tr>
            @endforelse
        </tbody>
    </table>

        <!-- Links de paginação -->
    <div class="d-flex justify-content-center">
      {{ $profissionais->links('pagination::bootstrap-5') }}
    </div>

@endsection