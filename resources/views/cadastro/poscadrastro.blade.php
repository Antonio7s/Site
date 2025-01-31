@extends('layouts.app')

@section('content')
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

    <!-- Mensagem de Sucesso (Aparece após o envio) -->
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
</div>

<script>
    document.getElementById('btnEnviarDocumentos').addEventListener('click', function() {
        document.getElementById('uploadSection').style.display = 'none';
        document.getElementById('documentosNecessarios').style.display = 'none';
        document.getElementById('mensagemSucesso').classList.remove('d-none');
    });
</script>
@endsection
