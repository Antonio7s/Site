@extends('layouts.layout-index')

@section('header_title', 'Falha no Pagamento - Cartão de Crédito')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Pagamento via Cartão de Crédito - Falha</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Erro no Pagamento</div>
                <div class="card-body text-center">
                    <p>Infelizmente, ocorreu uma falha ao processar o pagamento por Cartão de Crédito.</p>
                    <p>Por favor, tente novamente ou entre em contato com o suporte se o problema persistir.</p>
                    <a href="#" class="btn btn-primary mt-3">Tentar Novamente</a>
                    <a href="#" class="btn btn-secondary mt-3">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
