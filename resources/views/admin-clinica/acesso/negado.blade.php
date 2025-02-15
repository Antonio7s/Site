@extends('layouts.layout-index')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card text-center shadow-lg p-4" style="width: 24rem;">
        <div class="card-body">
            <h4 class="card-title text-danger">Cadastro Negado</h4>
            <p class="card-text">Infelizmente, seu cadastro não foi aprovado.</p>

            <div class="mt-3">
                <a href="{{ url('/') }}" class="btn btn-primary w-100">Página Inicial</a>
            </div>
        </div>
    </div>
</div>
@endsection
