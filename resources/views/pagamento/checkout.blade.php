@extends('layouts.layout-index')
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
                        </div>

                        <!-- Seção Cartão de Crédito -->
                        <form id="formCartao" action="{{ route('pagamento.finalizarCartao') }}" method="POST">
                            @csrf
                            <div id="creditCardSection">
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
                                            <label for="cardExpiry" class="form-label">Validade (MM/YYYY)</label>
                                            <input type="text" class="form-control" id="cardExpiry" name="cardExpiry">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cardCVV" class="form-label">CVV (3 dígitos)</label>
                                            <input type="text" class="form-control" id="cardCVV" name="cardCVV">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="installments" class="form-label">Parcelamento</label>
                                    <select class="form-select" id="installments" name="installments">
                                        <option value="1">
                                            1x de R$ {{ number_format($procedimento->valor) }}
                                        </option>
                                    </select>
                                </div>
                                <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                                <input type="hidden" name="clinica_id" value="{{ $clinica->id }}">
                                <input type="hidden" name="amount" value="{{ $procedimento->valor }}">
                                <input type="hidden" name="descricao" value="Consulta com {{ $medico->profissional_nome ?? 'médico' }}">

                                <div class="mb-3">
                                    <label for="postalCode" class="form-label">Cep da Cidade</label>
                                    <input type="text" class="form-control" id="postalCode" name="postalCode">
                                </div>

                                <div class="mb-3">
                                    <label for="addressNumber" class="form-label">Número do endereço</label>
                                    <input type="text" class="form-control" id="addressNumber" name="addressNumber">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Finalizar Pagamento</button>
                            </div>
                        </form>

                        <!-- Seção Pix -->
                        <form id="formPix" action="{{ route('pagamento.gerarPix') }}" method="POST">
                            @csrf
                            <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                            <input type="hidden" name="valor" value="{{ $procedimento->valor }}">
                            <input type="hidden" name="descricao" value="Consulta com {{ $medico->profissional_nome ?? 'médico' }}">
                            <div id="pixSection" class="hidden">
                                <button type="submit" class="btn btn-secondary w-100">Gerar PIX</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusão das bibliotecas jQuery e jQuery Mask Plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
      $(document).ready(function(){
          // Máscara para o número do cartão: 4 grupos de 4 dígitos
          $('#cardNumber').mask('0000 0000 0000 0000');

          // Máscara para a validade do cartão: MM/YYYY
          $('#cardExpiry').mask('00/0000');

          // Máscara para o CVV: 3 dígitos
          $('#cardCVV').mask('000');

          // Máscara para o CEP (opcional)
          $('#postalCode').mask('00000-000');
      });

      // Função para alternar a exibição das seções de pagamento
      function updatePaymentMethod() {
          $('#creditCardSection').addClass('hidden');
          $('#pixSection').addClass('hidden');

          const selectedMethod = $('input[name="paymentMethod"]:checked').val();
          if (selectedMethod === "cartao") {
              $('#creditCardSection').removeClass('hidden');
          } else if (selectedMethod === "pix") {
              $('#pixSection').removeClass('hidden');
          }
      }

      $('input[name="paymentMethod"]').on('change', updatePaymentMethod);

      // Atualiza a exibição ao carregar a página
      updatePaymentMethod();
    </script>
@endsection
