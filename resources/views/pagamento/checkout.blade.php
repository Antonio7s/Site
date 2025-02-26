@extends('layouts.layout-index')
@section('header_title', 'Agendamento')
@section('content') 
    <style>
        body { background-color: #f8f9fa; }
        .card-header { font-weight: bold; }
        .hidden { display: none; }
    </style>
    <div class="container py-5">
        <h2 class="mb-4 text-center">Checkout - MedExame</h2>
        <div class="row">
            <!-- Detalhes do Agendamento e Resumo do Pagamento -->
            <div class="col-lg-4 mb-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Detalhes do Agendamento</div>
                    <div class="card-body">
                        <p><strong>Médico:</strong> {{ $medico->profissional_nome ?? 'não informado' }}</p>
                        <p><strong>Data:</strong> {{ $horario->data }}</p>
                        <p><strong>Horário:</strong> {{ $horario->horario_inicio ?? 'não informado'}}</p>
                        <p><strong>Procedimento:</strong> {{ $procedimento->nome ?? 'não informado'}}</p>
                        <p><strong>Localização:</strong> {{ $clinica->nome_fantasia }}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-info text-white">Resumo do Pagamento</div>
                    <div class="card-body">
                        <p><strong>Consulta:</strong> {{ $procedimento->valor }}</p>
                        <hr>
                        <p class="h5 text-end"><strong>Total: {{ $procedimento->valor }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Informações do Cliente e Formas de Pagamento -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Dados do Cliente -->
                        <div class="mb-3">
                            <h1>Informações do Cliente</h1>
                            <p><strong>Nome:</strong> {{ Auth::user()->name ?? 'Não informado' }}</p>
                            <p><strong>CPF:</strong> {{ Auth::user()->cpf ?? 'Não informado' }}</p>
                            <p><strong>Telefone:</strong> {{ Auth::user()->telefone }}</p>
                            <p><strong>Data de Nascimento:</strong> {{ $user->data_nascimento ?? 'Não informado' }}</p>
                        </div>

                        <!-- Seleção do Método de Pagamento -->
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="radioCartao" value="cartao" checked>
                                <label class="form-check-label" for="radioCartao">Cartão de Crédito</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="radioPix" value="pix">
                                <label class="form-check-label" for="radioPix">Pix</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="radioBoleto" value="boleto">
                                <label class="form-check-label" for="radioBoleto">Boleto</label>
                            </div>
                        </div>

                        <!-- Seção Cartão de Crédito -->
                        <form id="formCartao" action="{{ route('pagamento.finalizarCartao') }}" method="POST">
                            @csrf
                            <div id="creditCardSection">
                                <div class="mb-3">
                                    <label for="savedCardSelect" class="form-label">Cartões Salvos</label>
                                    <select class="form-select" id="savedCardSelect" name="savedCard">
                                        <option value="new">Novo Cartão</option>
                                        <option value="card1" data-name="Carlos Oliveira" data-number="**** **** **** 1234" data-expiry="12/27">Visa - 1234</option>
                                        <option value="card2" data-name="Carlos Oliveira" data-number="**** **** **** 5678" data-expiry="07/26">MasterCard - 5678</option>
                                    </select>
                                </div>
                                <div id="cardDetails">
                                    <div class="mb-3">
                                        <label for="cardName" class="form-label">Nome do Titular</label>
                                        <input type="text" class="form-control" id="cardName" name="cardName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="cardNumber" class="form-label">Número do Cartão</label>
                                        <input type="text" class="form-control" id="cardNumber" name="cardNumber">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cardExpiry" class="form-label">Validade</label>
                                            <input type="text" class="form-control" id="cardExpiry" name="cardExpiry">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cardCVV" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cardCVV" name="cardCVV">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="installments" class="form-label">Parcelamento</label>
                                    <select class="form-select" id="installments" name="installments">
                                        <option value="1">1x de R$ 550,00 (Sem juros)</option>
                                        <option value="2">2x de R$ 275,00</option>
                                        <option value="3">3x de R$ 183,33</option>
                                        <option value="4">4x de R$ 137,50</option>
                                        <option value="5">5x de R$ 110,00</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Finalizar Pagamento</button>
                            </div>
                        </form>

                        <!-- Seção Pix -->
                        <form id="formPix" action="{{ route('pagamento.gerarPix') }}" method="POST">
                            @csrf
                            <input type="hidden" name="valor" value="{{ $procedimento->valor }}">
                            <input type="hidden" name="descricao" value="Consulta com {{ $medico->profissional_nome ?? 'médico' }}">
                            <div id="pixSection" class="hidden">
                                <p class="text-center">Escaneie o QR Code abaixo para pagar via Pix.</p>
                                <img src="https://via.placeholder.com/250" class="d-block mx-auto">
                                <button type="submit" class="btn btn-secondary w-100">Gerar PIX</button>
                            </div>
                        </form>

                        <!-- Seção Boleto -->
                        <form id="formBoleto" action="{{ route('pagamento.gerarBoleto') }}" method="POST">
                            @csrf
                            <input type="hidden" name="valor" value="{{ $procedimento->valor }}">
                            <input type="hidden" name="descricao" value="Consulta com {{ $medico->profissional_nome ?? 'médico' }}">
                            <div id="boletoSection" class="hidden">
                                <p class="text-center">Clique no botão abaixo para gerar o boleto.</p>
                                <button type="submit" class="btn btn-secondary w-100">Gerar Boleto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePaymentMethod() {
            document.getElementById('creditCardSection').classList.add('hidden');
            document.getElementById('pixSection').classList.add('hidden');
            document.getElementById('boletoSection').classList.add('hidden');

            const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            if (selectedMethod === "cartao") {
                document.getElementById('creditCardSection').classList.remove('hidden');
            } else if (selectedMethod === "pix") {
                document.getElementById('pixSection').classList.remove('hidden');
            } else if (selectedMethod === "boleto") {
                document.getElementById('boletoSection').classList.remove('hidden');
            }
        }

        document.querySelectorAll('input[name="paymentMethod"]').forEach(input => {
            input.addEventListener('change', updatePaymentMethod);
        });

        document.getElementById('savedCardSelect').addEventListener('change', function(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            if (selectedOption.value === 'new') {
                document.getElementById('cardName').value = '';
                document.getElementById('cardNumber').value = '';
                document.getElementById('cardExpiry').value = '';
            } else {
                document.getElementById('cardName').value = selectedOption.dataset.name;
                document.getElementById('cardNumber').value = selectedOption.dataset.number;
                document.getElementById('cardExpiry').value = selectedOption.dataset.expiry;
            }
        });

        updatePaymentMethod();
    </script>
@endsection
