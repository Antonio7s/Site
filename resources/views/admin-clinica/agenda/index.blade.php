@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <!-- Lista de profissionais -->


    <ul id="doctorList" class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Dr. João Silva
            <div class="btn-group" role="group" aria-label="Ações">
                <a href="{{ route('admin-clinica.agenda.agendamento.show') }}" class="btn btn-info btn-sm">Ver Agendamentos</a>
                <a href="{{ route('admin-clinica.agenda.horario.show') }}" class="btn btn-primary btn-sm">Ver Horários</a>
                <a href="{{ route('admin-clinica.agenda.horario.create') }}" class="btn btn-success btn-sm">Criar Horário</a>
            </div>
        </li>
    </ul>

@endsection