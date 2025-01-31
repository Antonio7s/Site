@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de procedimento')
@section('content')
    <div class="container mt-5, ms-2">
        <form>
            <div class="mb-3">
                <label for="" class="form-label">Procedimentos</label>
                <input type="text" class="form-controll" id="procedimento" required/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Preço</label>
                <input type="number" class="form-controll" id="preco" required/>
            </div>
            <button type="submit" class="btn btn-primary"> Cadastrar</button>
    </div>
@endsection