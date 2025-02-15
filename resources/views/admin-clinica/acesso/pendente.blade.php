@extends('layouts.layout-index')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card text-center shadow-lg p-4" style="width: 24rem;">
        <div class="card-body">
            <h4 class="card-title">Seus documentos serão analisados</h4>
            <p class="card-text">Aguarde enquanto processamos suas informações.</p>

            <div class="mt-3">
                <a href="{{ url('/') }}" class="btn btn-primary w-100 mb-2">Página Inicial</a>
                <a href="{{ url('/logout') }}" class="btn btn-danger w-100">Sair</a>
            </div>
        </div>
    </div>
</div>
@endsection

