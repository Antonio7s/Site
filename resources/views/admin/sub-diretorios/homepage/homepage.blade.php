@extends('layouts.painel-admin')
@section('header_title', 'Homepage') <!-- Alterando o h1 -->
@section('content')
    <div class="form-section ms-2">
        <h3>Configurações da Página Inicial</h3>
        <form id="formPaginaInicial">

            <!-- Seção Modificar Logo -->
            <div class="form-section">
                <h4>Modificar Logo</h4>
                <div class="mb-3">
                    <label for="logo" class="form-label">Escolha uma nova imagem para a Logo</label>
                    <input type="file" id="logo" class="form-control" accept="image/*">
                </div>
            </div>

            <hr>

            <!-- Seção Modificar Banner -->
            <div class="form-section">
                <h4>Modificar Banner</h4>
                <div class="mb-3">
                    <label for="banner" class="form-label">Escolha uma nova imagem para o Banner</label>
                    <input type="file" id="banner" class="form-control" accept="image/*">
                </div>
            </div>

            <hr>

            <!-- Seção Modificar ou Criar Novas Categorias de Agendamento -->
            <div class="form-section">
                <h4>Modificar ou Criar Categorias de Agendamento</h4>
                <div id="categoriesList">
                    <!-- Categorias existentes -->
                    <div class="category-item mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="categoryTitle1" class="form-label">Título da Categoria</label>
                                <input type="text" id="categoryTitle1" class="form-control" value="Consultas presenciais" placeholder="Nome da categoria">
                            </div>
                            <div class="col-md-4">
                                <label for="categoryIcon1" class="form-label">Ícone da Categoria</label>
                                <input type="text" id="categoryIcon1" class="form-control" value="👨‍⚕️" placeholder="Ícone (ex: 👨‍⚕️)">
                            </div>
                            <div class="col-md-4">
                                <label for="categoryColor1" class="form-label">Cor da Categoria</label>
                                <input type="color" id="categoryColor1" class="form-control" value="#17a2b8">
                            </div>
                        </div>
                    </div>

                    <!-- Adicione mais categorias conforme necessário -->
                </div>

                <!-- Botão para Adicionar Nova Categoria -->
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary" onclick="addNewCategory()">Adicionar Nova Categoria</button>
                </div>
            </div>

            <hr>

            <!-- Seção FAQ -->
            <div class="form-section">
                <h4>Perguntas Frequentes (FAQ)</h4>
                <!-- Pergunta 1 -->
                <div class="mb-3">
                    <label for="faqQuestion1" class="form-label">Pergunta 1</label>
                    <input type="text" id="faqQuestion1" class="form-control" value="O que é o MedExame?" placeholder="Insira a pergunta">
                </div>
                <div class="mb-3">
                    <label for="faqAnswer1" class="form-label">Resposta 1</label>
                    <textarea id="faqAnswer1" class="form-control" rows="5" placeholder="Insira a resposta">O MedExame é um sistema que permite que clínicas se cadastrem e ofereçam serviços como exames e consultas de forma prática e eficiente.</textarea>
                </div>

                <!-- Pergunta 2 -->
                <div class="mb-3">
                    <label for="faqQuestion2" class="form-label">Pergunta 2</label>
                    <input type="text" id="faqQuestion2" class="form-control" value="Como posso me cadastrar no sistema?" placeholder="Insira a pergunta">
                </div>
                <div class="mb-3">
                    <label for="faqAnswer2" class="form-label">Resposta 2</label>
                    <textarea id="faqAnswer2" class="form-control" rows="5" placeholder="Insira a resposta">Para se cadastrar, basta acessar a página inicial, clicar no botão "Cadastro" e preencher o formulário com seus dados.</textarea>
                </div>

                <!-- Botão para Adicionar Nova Pergunta -->
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary" onclick="addFaqQuestion()">Adicionar Nova Pergunta</button>
                </div>
            </div>
            
            <hr>

            <!-- Seção Informações Básicas -->
            <div class="form-section">
                <h4>Informações Básicas da Clínica</h4>
                <div class="mb-3">
                    <label for="infoBasicas" class="form-label">Informações sobre a clínica</label>
                    <textarea id="infoBasicas" class="form-control" rows="5" placeholder="Insira as informações básicas da clínica"></textarea>
                </div>
            </div>

            <hr>

            <!-- Seção QR Code -->
            <div class="form-section">
                <h4>Modificar Links do App</h4>
                <div class="mb-3">
                    <label for="playStoreLink" class="form-label">Link do App na Play Store</label>
                    <input type="url" id="playStoreLink" class="form-control" placeholder="Insira o link do app na Play Store">
                </div>
                <div class="mb-3">
                    <label for="apkLink" class="form-label">Link do APK</label>
                    <input type="url" id="apkLink" class="form-control" placeholder="Insira o link direto do APK">
                </div>
            </div>

            <!-- Botão Salvar -->
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
@endsection