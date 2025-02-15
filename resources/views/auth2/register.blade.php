@extends('layouts.layout-index')

@section('content')

<!-- Script do reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="card mx-auto mt-5 shadow" style="max-width: 500px; border: none;">
    <div class="card-header text-center" style="background: #fff; border-bottom: 1px solid #dee2e6;">
        <h4 style="color: #007bff; font-weight: bold;">Cadastro de Clínica</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register2') }}" enctype="multipart/form-data">
            @csrf

            <!-- Razão Social -->
            <div class="mb-3">
                <x-input-label for="razao_social" :value="__('Razão Social')" />
                <x-text-input id="razao_social" class="form-control" type="text" name="razao_social" :value="old('razao_social')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('razao_social')" class="mt-2" />
            </div>

            <!-- Nome Fantasia -->
            <div class="mb-3">
                <x-input-label for="nome_fantasia" :value="__('Nome Fantasia (Nome para divulgação)')" />
                <x-text-input id="nome_fantasia" class="form-control" type="text" name="nome_fantasia" :value="old('nome_fantasia')" required autocomplete="nome_fantasia" />
                <x-input-error :messages="$errors->get('nome_fantasia')" class="mt-2" />
            </div>

            <!-- CNPJ/CPF -->
            <div class="mb-3">
                <x-input-label for="cnpj_cpf" :value="__('CNPJ/CPF')" />
                <x-text-input id="cnpj_cpf" class="form-control" type="text" name="cnpj_cpf" :value="old('cnpj_cpf')" required autocomplete="cnpj_cpf" />
                <x-input-error :messages="$errors->get('cnpj_cpf')" class="mt-2" />
            </div>

            <!-- Telefone -->
            <div class="mb-3">
                <x-input-label for="telefone" :value="__('Telefone')" />
                <x-text-input id="telefone" class="form-control" type="text" name="telefone" :value="old('telefone')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Senha -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Senha')" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Senha -->
            <div class="mb-3">
                <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Botão "i" de Informações -->
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <li>RG, CPF do Responsável pelo Contrato</li>
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
                <x-input-label for="documentos" :value="__('Anexar Documentos (PDF)')" />
                <input type="file" id="documentos" name="documentos[]" class="form-control" accept="application/pdf" multiple required>
                <small class="text-muted">Envie todos os documentos necessários em formato PDF.</small>
                <x-input-error :messages="$errors->get('documentos')" class="mt-2" />
            </div>

            <!-- Widget do reCAPTCHA -->
            <div class="g-recaptcha mt-3" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            @if ($errors->has('g-recaptcha-response'))
                <div class="error text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
            @endif

            <!-- Botões -->
            <div class="d-flex justify-content-between align-items-center mt-3">
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

<!-- Bootstrap JS (para modal funcionar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection




