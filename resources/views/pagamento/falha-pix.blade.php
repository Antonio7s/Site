@extends('layouts.layout-index')


@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Pagamento via Pix - Falha</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Erro no Pagamento</div>
                <div class="card-body text-center">
                    <p>Infelizmente, ocorreu uma falha ao processar o pagamento via Pix.</p>
                    <p>Verifique os dados e tente novamente ou escolha outro método de pagamento.</p>
                    <a href="#" class="btn btn-primary mt-3">Tentar Novamente</a>
                    <a href="#" class="btn btn-secondary mt-3">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
