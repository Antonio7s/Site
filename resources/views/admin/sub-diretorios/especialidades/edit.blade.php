@extends('layouts.painel-admin')
@section('header_title', 'Edição de Especialidades')
@section('content')

<form action="{{ route('admin.especialidades.update', $especialidade->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nome" class="form-label">Especialidade</label>
        <input type="text" name="nome" class="form-control" id="nome" required value="{{ $especialidade->nome }}">
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('admin.especialidades.index') }}" class="btn btn-primary">Voltar</a>
</form>



@endsection