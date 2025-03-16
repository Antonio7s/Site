@extends('layouts.painel-clinica')
@section('header_title', 'Horários do Médico')
@section('content')

@php
\Carbon\Carbon::setLocale('pt_BR');
@endphp

<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Agenda de {{$profissional->profissional_nome}}</h5>
        <a href="{{ route('admin-clinica.agenda.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    @if($horarios->isEmpty())
        <div class="alert alert-info">
            Nenhum horário cadastrado para este profissional.
        </div>
    @else
        <div class="schedule-container">
            @foreach($horarios->groupBy('data') as $date => $dailySchedules)
                <div class="day-card mb-4">
                    <div class="day-header p-3 bg-light rounded-top">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-day me-2"></i>
                            {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </h6>
                    </div>
                    
                    <div class="time-slots p-3 border">
                        @foreach($dailySchedules as $schedule)
                            <div class="time-slot d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div class="time-info">
                                    <span class="badge bg-primary me-2">
                                        {{ \Carbon\Carbon::parse($schedule->horario_inicio)->format('H:i') }}
                                    </span>
                                    <span class="text-muted small">
                                        ({{ $schedule->duracao }} minutos)
                                    </span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="procedure-info me-3">
                                        <span class="fw-medium">
                                            {{ $schedule->procedimento->nome }}
                                        </span>
                                    </div>
                                    <form method="POST" action="#" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este horário?')">
                                            <i class="fas fa-trash-alt"></i> X
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .day-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .time-slot:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .delete-form {
        line-height: 1;
    }
</style>

@endsection