@extends('layouts.layout-index')

@section('content')
<!-- Script do reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Scripts para jQuery e máscaras -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- CSS Personalizado para Responsividade -->
<style>
  /* Estilos para telas pequenas (celulares) */
  @media (max-width: 767.98px) {
    .card { margin-top: 1rem !important; }
    .card-header h4 { font-size: 1.5rem; }
    .form-control { font-size: 14px; }
    .btn { width: 100%; margin-bottom: 0.5rem; }
    .g-recaptcha { transform: scale(0.85); transform-origin: left top; }
    .modal-body ul { padding-left: 1rem; }
  }
  /* Estilos para telas médias (tablets) */
  @media (min-width: 768px) and (max-width: 991.98px) {
    .card { margin-top: 2rem; }
    .form-control { font-size: 15px; }
  }
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card shadow mt-5">
        <div class="card-header text-center bg-white border-bottom">
          <h4 style="color: #007bff; font-weight: bold;">Cadastro de Clínica</h4>
        </div>
        <div class="card-body">
          <p class="mb-4"><small>Campos marcados com <span class="text-danger">*</span> são obrigatórios. Os demais são opcionais.</small></p>
          <form method="POST" action="{{ route('register2.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Seção: Dados da Clínica -->
            <h5 class="mb-3">Dados da Clínica</h5>
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="razao_social" :value="__('Razão Social *')" />
                <x-text-input id="razao_social" class="form-control" type="text" name="razao_social" :value="old('razao_social')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('razao_social')" class="mt-2" />
              </div>
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="nome_fantasia" :value="__('Nome Fantasia (Nome para divulgação) *')" />
                <x-text-input id="nome_fantasia" class="form-control" type="text" name="nome_fantasia" :value="old('nome_fantasia')" required autocomplete="nome_fantasia" />
                <x-input-error :messages="$errors->get('nome_fantasia')" class="mt-2" />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="cnpj_cpf" :value="__('CNPJ/CPF *')" />
                <x-text-input id="cnpj_cpf" class="form-control" type="text" name="cnpj_cpf" :value="old('cnpj_cpf')" required autocomplete="cnpj_cpf" />
                <x-input-error :messages="$errors->get('cnpj_cpf')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="telefone" :value="__('Telefone *')" />
                <x-text-input id="telefone" class="form-control" type="text" name="telefone" :value="old('telefone')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="email" :value="__('Email *')" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-3 mb-3">
                <x-input-label for="cep" :value="__('CEP *')" />
                <x-text-input id="cep" class="form-control" type="text" name="cep" :value="old('cep')" required autocomplete="cep" />
                <x-input-error :messages="$errors->get('cep')" class="mt-2" />
              </div>
              <div class="col-12 col-md-5 mb-3">
                <x-input-label for="endereco" :value="__('Endereço *')" />
                <x-text-input id="endereco" class="form-control" type="text" name="endereco" :value="old('endereco')" required autocomplete="endereco" />
                <x-input-error :messages="$errors->get('endereco')" class="mt-2" />
              </div>
              <div class="col-12 col-md-2 mb-3">
                <x-input-label for="numero" :value="__('Número *')" />
                <x-text-input id="numero" class="form-control" type="text" name="numero" :value="old('numero')" required autocomplete="numero" />
                <x-input-error :messages="$errors->get('numero')" class="mt-2" />
              </div>
              <div class="col-12 col-md-2 mb-3">
                <x-input-label for="complemento" :value="__('Complemento (Opcional)')" />
                <x-text-input id="complemento" class="form-control" type="text" name="complemento" :value="old('complemento')" autocomplete="complemento" />
                <x-input-error :messages="$errors->get('complemento')" class="mt-2" />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="bairro" :value="__('Bairro *')" />
                <x-text-input id="bairro" class="form-control" type="text" name="bairro" :value="old('bairro')" required autocomplete="bairro" />
                <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="cidade" :value="__('Cidade *')" />
                <x-text-input id="cidade" class="form-control" type="text" name="cidade" :value="old('cidade')" required autocomplete="cidade" />
                <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="uf" :value="__('UF *')" />
                <select id="uf" name="uf" class="form-select" required>
                  <option value="">{{ __('Selecione') }}</option>
                  @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                    <option value="{{ $uf }}" {{ old('uf') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                  @endforeach
                </select>
                <x-input-error :messages="$errors->get('uf')" class="mt-2" />
              </div>
            </div>

            <hr>
            <h5 class="mb-3">Informações de contato</h5>
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="email_administrativo" :value="__('E-mail Administrativo *')" />
                <x-text-input id="email_administrativo" class="form-control" type="email" name="email_administrativo" :value="old('email_administrativo')" required autocomplete="email_administrativo" />
                <x-input-error :messages="$errors->get('email_administrativo')" class="mt-2" />
              </div>
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="email_faturamento" :value="__('E-mail Faturamento *')" />
                <x-text-input id="email_faturamento" class="form-control" type="email" name="email_faturamento" :value="old('email_faturamento')" required autocomplete="email_faturamento" />
                <x-input-error :messages="$errors->get('email_faturamento')" class="mt-2" />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="telefone_local" :value="__('Telefone do Local *')" />
                <x-text-input id="telefone_local" class="form-control" type="text" name="telefone_local" :value="old('telefone_local')" required autocomplete="telefone_local" placeholder="(00) 0000-0000" />
                <x-input-error :messages="$errors->get('telefone_local')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="telefone_financeiro" :value="__('Telefone Financeiro *')" />
                <x-text-input id="telefone_financeiro" class="form-control" type="text" name="telefone_financeiro" :value="old('telefone_financeiro')" required autocomplete="telefone_financeiro" placeholder="(00) 0000-0000" />
                <x-input-error :messages="$errors->get('telefone_financeiro')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="celular" :value="__('Celular *')" />
                <x-text-input id="celular" class="form-control" type="text" name="celular" :value="old('celular')" required autocomplete="celular" placeholder="(00) 00000-0000" />
                <x-input-error :messages="$errors->get('celular')" class="mt-2" />
              </div>
            </div>

            <hr>
            <h5 class="mt-4 mb-3">Responsável pelo Contrato</h5>
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="responsavel_nome" :value="__('Nome Completo *')" />
                <x-text-input id="responsavel_nome" class="form-control" type="text" name="responsavel_nome" :value="old('responsavel_nome')" required autocomplete="responsavel_nome" />
                <x-input-error :messages="$errors->get('responsavel_nome')" class="mt-2" />
              </div>
              <div class="col-12 col-md-3 mb-3">
                <x-input-label for="rg" :value="__('RG *')" />
                <x-text-input id="rg" class="form-control" type="text" name="rg" :value="old('rg')" required autocomplete="rg" />
                <x-input-error :messages="$errors->get('rg')" class="mt-2" />
              </div>
              <div class="col-12 col-md-3 mb-3">
                <x-input-label for="orgao_emissor" :value="__('Órgão Emissor *')" />
                <x-text-input id="orgao_emissor" class="form-control" type="text" name="orgao_emissor" :value="old('orgao_emissor')" required autocomplete="orgao_emissor" />
                <x-input-error :messages="$errors->get('orgao_emissor')" class="mt-2" />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="data_emissao" :value="__('Data de Emissão *')" />
                <x-text-input id="data_emissao" class="form-control" type="text" name="data_emissao" :value="old('data_emissao')" required autocomplete="data_emissao" placeholder="dd/mm/aaaa" />
                <x-input-error :messages="$errors->get('data_emissao')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="cpf" :value="__('CPF *')" />
                <x-text-input id="cpf" class="form-control" type="text" name="cpf" :value="old('cpf')" required autocomplete="cpf" placeholder="000.000.000-00" />
                <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
              </div>
              <div class="col-12 col-md-4 mb-3">
                <x-input-label for="estado_civil" :value="__('Estado Civil *')" />
                <x-text-input id="estado_civil" class="form-control" type="text" name="estado_civil" :value="old('estado_civil')" required autocomplete="estado_civil" />
                <x-input-error :messages="$errors->get('estado_civil')" class="mt-2" />
              </div>
            </div>

            <hr>
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="password" :value="__('Senha *')" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div class="col-12 col-md-6 mb-3">
                <x-input-label for="password_confirmation" :value="__('Confirmar Senha *')" />
                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
              </div>
            </div>

            <!-- Botão de informações sobre documentos -->
            <div class="mb-3">
              <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDocumentos">
                <i class="fas fa-info-circle"></i> Documentos Necessários
              </button>
            </div>

            <!-- Modal de Informações sobre os Documentos -->
            <div class="modal fade" id="modalDocumentos" tabindex="-1" aria-labelledby="modalDocumentosLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalDocumentosLabel">Documentos Necessários</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Comprovante Bancário</li>
                      <li>Alvará de Funcionamento</li>
                      <li>Alvará de Licença Sanitária</li>
                      <li>Carteira do Conselho do Responsável Técnico</li>
                      <li>RG, CPF e E-mail do Responsável pelo Contrato</li>
                      <li>Contrato Social</li>
                      <li>Diploma</li>
                      <li>Títulos</li>
                      <li>Identidade Profissional</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Upload de Documentos -->
            <div class="mb-3">
              <x-input-label for="documentos" :value="__('Anexar Documento (PDF) *')" />
              <input type="file" id="documentos" name="documentos" class="form-control" accept="application/pdf" required>
              <small class="text-muted">Envie o documento necessário em formato PDF.</small>
              <x-input-error :messages="$errors->get('documentos')" class="mt-2" />
            </div>

            <!-- Widget do reCAPTCHA -->
            <div class="g-recaptcha mt-3" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            @if ($errors->has('g-recaptcha-response'))
              <div class="error text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
            @endif

            <!-- Botões -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <a class="text-decoration-none" href="{{ route('login2') }}">
                {{ __('Já possui cadastro?') }}
              </a>
              <x-primary-button class="btn btn-primary">
                {{ __('Cadastrar') }}
              </x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts customizados: máscaras e validação do reCAPTCHA -->
<script>
  $(document).ready(function(){
    $('#telefone_local').mask('(00) 0000-0000');
    $('#telefone_financeiro').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#cep').mask('00000-000');
    $('#data_emissao').mask('00/00/0000');

    $('form').submit(function(e){
      if (typeof grecaptcha !== 'undefined' && grecaptcha.getResponse() == ''){
        e.preventDefault();
        alert('Por favor, clique no reCAPTCHA.');
      }
    });
  });
</script>
@endsection
