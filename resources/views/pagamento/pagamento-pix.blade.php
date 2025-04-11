@extends('layouts.layout-index')

@section('header_title', 'Pagamento via Pix')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Pagamento via Pix</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">QR Code para Pagamento</div>
                <div class="card-body text-center">
                    
                    <p>Escaneie o QR Code abaixo com seu aplicativo de pagamento para efetuar o pagamento.</p>
                    <img src="{{ $qrcode }}" alt="QR Code Pix" class="img-fluid mb-3">
                    <p><strong>Valor: </strong>R$ {{ number_format($valor, 2, ',', '.') }}</p>
                    <p>Após o pagamento, aguarde a confirmação.</p>
                    <a href="{{ route('index') }}" class="btn btn-primary mt-3">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Suponha que o id do agendamento esteja disponível na view
    //let agendamentoId = {{ $agendamento->id ?? 'null' }};
    let agendamentoId = {{ $agendamento_id ?? 'null' }};


    function verificarPagamento() {
        if (!agendamentoId) return; // Evita chamadas sem o id
        
        fetch(`/pagamento/verificar-pagamento?agendamento_id=${agendamentoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.aprovado) {
                    window.location.href = "{{ route('pagamento.sucessoPix') }}";
                }
            })
            .catch(error => console.error('Erro ao verificar pagamento:', error));
    }

    setInterval(verificarPagamento, 1500); // Verifica a cada 1.5 segundos

</script>

@endsection
