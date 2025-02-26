@extends('layouts.layout-index')

@section('header_title', 'Pagamento via Boleto')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Pagamento via Boleto</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">Boleto para Pagamento</div>
                <div class="card-body text-center">
                    <p>Para efetuar o pagamento, clique no botão abaixo para visualizar ou baixar o boleto.</p>
                    
                    <a href="{{ $boletoUrl }}" target="_blank" class="btn btn-success">
                        Visualizar Boleto
                    </a>

                    <p class="mt-3"><strong>Valor: </strong>R$ {{ number_format($valor, 2, ',', '.') }}</p>
                    <p>Após o pagamento, aguarde a confirmação.</p>
                    <a href="#" class="btn btn-primary mt-3">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
