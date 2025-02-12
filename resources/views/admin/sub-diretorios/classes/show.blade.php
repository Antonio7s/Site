@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de classes')

@section('content')

    <form>
        <div class="mb-3">
                    <label for="nome" class="form-label">Especialidade</label>
                    <input type="text" name="nome" class="form-control" id="nome" readonly value="{{ $classe->nome }}">
                </div>
                <a href="{{ route('admin.classes.index') }}" type="submit" class="btn btn-primary">Voltar</a>
        </div>
    </form>

@endsection