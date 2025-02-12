@extends('layouts.painel-admin')
@section('header_title', 'Visualização de Especialidades')
@section('content')

<form>
    <div class="mb-3">
                <label for="nome" class="form-label">Especialidade</label>
                <input type="text" name="nome" class="form-control" id="nome" readonly value="{{ $especialidade->value }}">
            </div>
            <a href="{{ route('admin.especialidades.index') }}" type="submit" class="btn btn-primary">Voltar</a>
    </div>
</form>

@endsection