@extends('layouts.painel-admin')
@section('header_title', 'Cadastro de classes')

@section('content')
    <div class="container mt-5 ms-2">
        <form>
            <div class="mb-3">
                <label for="" class="form-label"> Classes</label>
                <input type="text" class="form-controll" id="classe" required></input>
            </div>
            <button type="submit" class="btn btn-primary"> Cadastrar</button>
        </form>
    </div>
@endsection