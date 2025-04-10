@extends('layouts.layout-index')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Pagamento via Cartão de Crédito - Sucesso</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">Pagamento Realizado com Sucesso!</div>
                <div class="card-body text-center">
                    <p>O pagamento via Cartão de crédito foi processado com sucesso.</p>
                    <p>Você pode acompanhar o status do seu pedido a qualquer momento.</p>
                    <a href="{{ route('perfil.meusPedidos') }}" class="btn btn-primary mt-3">Ir para Meus Pedidos</a>
                    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
