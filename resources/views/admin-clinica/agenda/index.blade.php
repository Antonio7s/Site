@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <div>
        <!-- Agendamento -->
        <div id="agendamento" class="">
            <h3>Agendamento</h3>
            <input type="text" id="searchDoctor" class="form-control" placeholder="Pesquisar médico">
            <ul id="doctorList" class="list-group mt-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Dr. João Silva
                    <button class="btn btn-primary btn-sm">Horário</button>
                </li>
            </ul>
            <div id="horariosSection">
                <h4 class="mt-4">Horários para <span id="doctorName"></span></h4>
                <div id="horariosContainer"></div>
                <button type="button" class="btn btn-success mt-2" >Adicionar Horário</button>
            </div>
        </div>
    </div>

@endsection