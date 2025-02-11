@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de procedimento')
@section('content')
    <div class="container mt-5, ms-2">
        <form>
            <div class="col-md-4">
                <label class="form-label">Tipo de Procedimento</label>
                <select class="form-select">
                    <option selected>Padrão</option>
                    <option>Personalizado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Vinculado a clínica</label>
                <input type="text" class="form-controll" id="procedimento" required/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nome Procedimento:</label>
                <input type="text" class="form-controll" id="procedimento" required/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Preço</label>
                <input type="number" class="form-controll" id="preco" required/>
            </div>
            <button type="submit" class="btn btn-primary"> Cadastrar</button>
    </div>
@endsection