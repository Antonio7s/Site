@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de Especialidades')
@section('content')
<div class="container mt-5 ms-2">
    <!-- Mostra mensagens de sucesso ou erros, se houver -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Exibe erros de validação -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.especialidades.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Especialidade</label>
            <input type="text" name="nome" class="form-control" id="nome" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
@endsection
