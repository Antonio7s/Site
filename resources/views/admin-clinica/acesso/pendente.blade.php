@extends('layouts.layout-index')
<!-- Referencia o layout 'layout-index.blade.php' -->

@section('content')
<div class="container text-center mt-5">
    <h2>Seus documentos serão analisados</h2>
    <p>Aguarde enquanto processamos suas informações.</p>

    <div class="mt-4">
        <a href="{{ ('#') }}" class="btn btn-primary">Página Inicial</a>
        <a href="{{ ('#') }}" class="btn btn-danger">Sair</a>
    </div>
</div>
@endsection
