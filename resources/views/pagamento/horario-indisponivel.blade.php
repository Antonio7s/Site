@extends('layouts.layout-index')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Conflito de Horário</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">Horário Indisponível!</div>
                <div class="card-body text-center">
                    <p>O horário selecionado já foi reservado por outro cliente.</p>
                    <p>Por favor, escolha outro horário disponível ou verifique seus agendamentos existentes.</p>
                    <a href="#" class="btn btn-primary mt-3">Escolher Novo Horário</a>
                    <a href="{{ route('perfil.meusPedidos') }}" class="btn btn-secondary mt-3">Ver Meus Agendamentos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection