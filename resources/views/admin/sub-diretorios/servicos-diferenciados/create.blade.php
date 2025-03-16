@extends('layouts.painel-admin')
@section('header_title', 'Serviços diferenciados') 
@section('content')

<div class="container mt-5 ms-2">        
    <!-- Formulário de Cadastro -->
    <form action="{{ route('admin.servicos-diferenciados.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="clinica" class="form-label">Clínica vinculada</label>
            <select class="form-select" name="clinica_id" id="clinica" required>
                <option value="" selected disabled>Selecione uma clínica</option>
                @foreach($clinicas as $clinica)
                    <option value="{{ $clinica->id }}">{{ $clinica->nome_fantasia ?? 'Não informado' }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="dataInicial" class="form-label">Data Inicial</label>
            <input type="date" class="form-control" name="dataInicial" id="dataInicial" required>
        </div>
        <div class="mb-3">
            <label for="dataFinal" class="form-label">Data Final</label>
            <input type="date" class="form-control" name="dataFinal" id="dataFinal">
        </div>

        <div class="mb-3">
            <label for="procedimento" class="form-label">Procedimento</label>
            <select class="form-select" name="procedimento_id" id="procedimento" required>
                <option value="" selected disabled>Selecione um procedimento</option>
                @foreach($procedimentos as $procedimento)
                    <option value="{{ $procedimento->id }}">{{ $procedimento->nome ?? 'Não informado' }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="preco_customizado" class="form-label">Valor</label>
            <input type="number" class="form-control" name="preco_customizado" id="preco_customizado" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
@endsection
