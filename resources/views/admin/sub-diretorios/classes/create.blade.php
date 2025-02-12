@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de classes')

@section('content')

    <div class="container mt-5 ms-2">
        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nome" class="form-label">Classe</label>
                <input type="text" class="form-controll" id="nome" name="nome" required></input>
            </div>
            <button type="submit" class="btn btn-primary"> Cadastrar</button>
            <a href="#" class="btn btn-primary"> Voltar</a>
        </form>
    </div>

@endsection