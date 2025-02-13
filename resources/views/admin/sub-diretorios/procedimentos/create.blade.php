@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de procedimento')
@section('content')
    <div class="container mt-5, ms-2">
        <form action="{{ route('admin.procedimentos.store') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" value="{{ old('nome') }}" required/>
            </div>

            <div class="mb-3">
                <label for="classe_id" class="form-label">Classe</label>
                <select name="classe_id" class="form-select" id="classe" required>
                    <option value="#" selected disabled>Selecione uma classe</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" name="valor" class="form-control" id="valor" value="{{ old('valor') }}" required/>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="{{ route('admin.procedimentos.index') }}" class="btn btn-primary">Voltar</a>
        </form>
    </div>
@endsection
