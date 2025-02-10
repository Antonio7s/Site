@extends('layouts.layout-index')

@section('content')
@if(session('registrationSuccess'))
    <!-- Etapa de Upload de Documentos (após o cadastro) -->
    <div class="container text-center py-5">
        <!-- Caixa de Upload de Documentos -->
        <div class="card shadow-sm p-4 mx-auto mb-4" id="uploadSection" style="max-width: 500px;">
            <h4 class="fw-bold">Insira seus documentos abaixo</h4>
            <p class="text-muted">Faça o upload dos documentos necessários para continuar.</p>
            
            <input type="file" class="form-control mb-3" multiple>
            <button class="btn btn-primary" id="btnEnviarDocumentos">Enviar Documentos</button>
        </div>

        <!-- Lista de Documentos Necessários -->
        <div class="card shadow-sm p-4 mx-auto mb-4" id="documentosNecessarios" style="max-width: 500px;">
            <h5 class="fw-bold">Documentos Necessários</h5>
            <ul class="text-start">
                <li>FORMULÁRIO DE PROPOSTA DE CONVÊNIO PREENCHIDO</li>
                <li>C.N.E.S. (Cadastro Nacional de Estabelecimento de Saúde)</li>
                <li>C.N.P.J.</li>
                <li>Comprovante Bancário</li>
                <li>Alvará de Funcionamento</li>
                <li>Alvará de Licença Sanitária</li>
                <li>Certidão de Responsabilidade Técnica</li>
                <li>Carteira do Conselho do Responsável Técnico</li>
                <li>Registro da Empresa junto ao Conselho de Classe</li>
                <li>RG, CPF e E-mail do Responsável pelo Contrato</li>
                <li>Contrato Social e Alterações, se houver</li>
                <li>Diploma</li>
                <li>Títulos</li>
                <li>Identidade Profissional</li>
            </ul>
        </div>

        <!-- Mensagem de Sucesso (opcional, após o envio dos documentos) -->
        <div class="card shadow-sm p-4 mx-auto d-none" id="mensagemSucesso" style="max-width: 500px;">
            <div class="text-success mb-3">
                <i class="fas fa-check-circle fa-4x"></i>
            </div>
            <h3 class="fw-bold">Cadastro Realizado com Sucesso!</h3>
            <p class="text-muted">Seus documentos foram enviados e estão em análise. Você será notificado assim que forem aprovados.</p>
            
            <!-- Ações Sugeridas -->
            <div class="d-flex justify-content-center mt-4">
                <a href="/" class="btn btn-primary">Voltar ao Início</a>
            </div>
        </div>

        <script>
            document.getElementById('btnEnviarDocumentos').addEventListener('click', function() {
                document.getElementById('uploadSection').style.display = 'none';
                document.getElementById('documentosNecessarios').style.display = 'none';
                document.getElementById('mensagemSucesso').classList.remove('d-none');
            });
        </script>
    </div>
@else
    <!-- Formulário de Cadastro (etapa inicial) -->
    <div class="card mx-auto mt-5 shadow" style="max-width: 500px; border: none;">
        <div class="card-header text-center" style="background: #fff; border-bottom: 1px solid #dee2e6;">
             <h4 style="color: #007bff; font-weight: bold;">Cadastro de Clínica</h4>
        </div>
        <div class="card-body">
             <form method="POST" action="{{ route('register2') }}">
                 @csrf

                 <!-- Razão Social -->
                 <div class="mb-3">
                     <x-input-label for="name" :value="__('Razão Social')" />
                     <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                     <x-input-error :messages="$errors->get('name')" class="mt-2" />
                 </div>

                 <!-- Nome Fantasia -->
                 <div class="mb-3">
                     <x-input-label for="nome_fantasia" :value="__('Nome Fantasia')" />
                     <x-text-input id="nome_fantasia" class="form-control" type="text" name="nome_fantasia" :value="old('nome_fantasia')" required autocomplete="nome_fantasia" />
                     <x-input-error :messages="$errors->get('nome_fantasia')" class="mt-2" />
                 </div>

                 <!-- CNPJ/CPF -->
                 <div class="mb-3">
                     <x-input-label for="document" :value="__('CNPJ/CPF')" />
                     <x-text-input id="document" class="form-control" type="text" name="document" :value="old('document')" required autocomplete="document" />
                     <x-input-error :messages="$errors->get('document')" class="mt-2" />
                 </div>

                 <!-- Email -->
                 <div class="mb-3">
                     <x-input-label for="email" :value="__('Email')" />
                     <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                     <x-input-error :messages="$errors->get('email')" class="mt-2" />
                 </div>

                 <!-- Password -->
                 <div class="mb-3">
                     <x-input-label for="password" :value="__('Password')" />
                     <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                     <x-input-error :messages="$errors->get('password')" class="mt-2" />
                 </div>

                 <!-- Confirm Password -->
                 <div class="mb-3">
                     <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                     <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                     <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                 </div>

                 <div class="d-flex justify-content-between align-items-center">
                     <a class="text-decoration-none" href="{{ route('login2') }}">
                         {{ __('Já possui cadastro?') }}
                     </a>
                     <x-primary-button class="btn btn-primary">
                         {{ __('Cadastro') }}
                     </x-primary-button>
                 </div>
             </form>
        </div>
    </div>
@endif
@endsection

