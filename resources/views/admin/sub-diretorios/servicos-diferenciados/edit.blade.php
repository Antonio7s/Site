@extends('layouts.painel-admin')

@section('header_title', 'Editar Serviço Diferenciado')

@section('content')
<div class="container mt-5">
    <h2>Editar Serviço Diferenciado</h2>
    <form action="{{ route('admin.servicos-diferenciados.update', $servico->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="clinica_id" class="form-label">Clínica vinculada</label>
            <select name="clinica_id" id="clinica_id" class="form-select" required>
                <option value="" disabled>Selecione uma clínica</option>
                @foreach($clinicas as $clinica)
                    <option value="{{ $clinica->id }}"
                        {{ $servico->clinica_id == $clinica->id ? 'selected' : '' }}>
                        {{ $clinica->nome_fantasia ?? 'Não informado' }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="dataInicial" class="form-label">Data Inicial</label>
            <input type="date" name="dataInicial" id="dataInicial" class="form-control"
                   value="{{ $servico->data_inicial }}" required>
        </div>
        
        <div class="mb-3">
            <label for="dataFinal" class="form-label">Data Final</label>
            <input type="date" name="dataFinal" id="dataFinal" class="form-control"
                   value="{{ $servico->data_final }}">
        </div>
        
        <div class="mb-3">
            <label for="procedimento_id" class="form-label">Procedimento</label>
            <select name="procedimento_id" id="procedimento_id" class="form-select" required>
                <option value="" disabled>Selecione um procedimento</option>
                @foreach($procedimentos as $procedimento)
                    <option value="{{ $procedimento->id }}"
                        {{ $servico->procedimento_id == $procedimento->id ? 'selected' : '' }}>
                        {{ $procedimento->nome ?? 'Não informado' }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" name="valor" id="valor" class="form-control"
                   step="0.01" value="{{ $servico->valor }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
