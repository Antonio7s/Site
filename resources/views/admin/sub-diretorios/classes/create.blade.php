@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de classes')

@section('content')
    <div class="container mt-5 ms-2">
        <form action="{{ route('admin.classes.store') }}" method="POST">
            <div class="mb-3">
                <label for="" class="form-label"> Nome da Classe:</label>
                <input type="text" class="form-controll" id="nome" required></input>
            </div>
            <button type="submit" class="btn btn-primary"> Cadastrar</button>
        </form>
    </div>
@endsection