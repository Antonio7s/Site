@extends('layouts.painel-admin')
@section('header_title', 'Edição de Procedimento')
@section('content')

<form action="{{ route('admin.procedimentos.update', $procedimento->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nome" class="form-label">Procedimento</label>
        <input type="text" name="nome" class="form-control" id="nome" required value="{{ $procedimento->nome }}">
    </div>

    <div class="mb-3">
        <label for="classe_id" class="form-label">Classe</label>
        <select name="classe_id" class="form-select" id="classe" required>
            <option value="" disabled selected>Selecione uma classe</option>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}"
                    {{ old('classe_id', $procedimento->classe_id) == $classe->id ? 'selected' : '' }}>
                    {{ $classe->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label" >Valor</label>
        <input name="valor" type="number" class="form-controll" id="valor" required value="{{ old('valor', $procedimento->valor) }}"/>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('admin.procedimentos.index') }}" class="btn btn-primary">Voltar</a>
</form>



@endsection