@extends('layouts.appusuarioautentificado')

@push('styles')   
<style>
    /* Estilos básicos */
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
    }

    .pedido {
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
    }

    .pedido h3 {
        margin: 0;
        color: #007bff;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <h2>Pedidos e Exames</h2>
    
    @foreach ($pedidos as $pedido)
        <div class="pedido">
            <h3>Pedido #{{ $pedido->id }}</h3>
            <p><strong>Cliente:</strong> {{ $pedido->cliente->nome }}</p>
            <p><strong>Exame:</strong> {{ $pedido->exame->nome }}</p>
            <p><strong>Data:</strong> {{ $pedido->created_at->format('d/m/Y') }}</p>
        </div>
    @endforeach
</div>
@endsection
