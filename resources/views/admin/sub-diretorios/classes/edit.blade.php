@extends('layouts.painel-admin')

@section('header_title', 'Cadastro de Classes')

@section('content')
    <div class="container mt-5 ms-2">
        <h2 class="mb-4">Editar Classe</h2>

        {{-- Exibe mensagens de erro --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.classes.update', $classe->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Classe</label>
                <input 
                    type="text" 
                    class="form-control @error('nome') is-invalid @enderror" 
                    name="nome" 
                    id="nome" 
                    required 
                    value="{{ old('nome', $classe->nome) }}"
                >
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
