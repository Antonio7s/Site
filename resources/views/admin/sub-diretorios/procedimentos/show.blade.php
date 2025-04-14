@extends('layouts.painel-admin')
@section('header_title', 'Visualização de Procedimentos')
@section('content')

<form>
    <div class="mb-3">
        <label for="nome" class="form-label">Especialidade</label>
        <input type="text" name="nome" class="form-control" id="nome" readonly value="{{ $procedimento->nome }}">
    </div>
    <div class="mb-3">
        <label for="valor" class="form-label" name="valor" >Valor</label>
        <input type="number" class="form-controll" id="valor" readonly value="{{ $procedimento->valor }}"/>
    </div>
            <a href="{{ route('admin.procedimentos.index') }}" type="submit" class="btn btn-primary">Voltar</a>
    </div>
</form>

@endsection