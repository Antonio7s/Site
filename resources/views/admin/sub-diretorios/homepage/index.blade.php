@extends('layouts.painel-admin')  
@section('header_title', 'Homepage') 
@section('content')
    <style>
        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .form-section h4 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .btn-outline-primary {
            border-radius: 20px;
        }

        @media (max-width: 768px) {
            .form-section {
                padding: 15px;
            }
            .category-item .row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .category-item .col-md-4,
            .category-item .col-md-3 {
                width: 100%;
            }
            .category-item .col-md-1 {
                width: auto;
                display: flex;
                justify-content: flex-end;
                align-items: center;
            }
            .category-item .btn-danger {
                width: auto;
                padding: 5px 10px;
            }
            .btn-outline-primary, .btn-primary {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .category-item .row {
                flex-direction: column;
                gap: 5px;
            }
            .category-item .btn-danger {
                width: 100%;
            }
        }
    </style>

    <div class="form-section ms-2">
        <h3>Configurações da Página Inicial</h3>
        <form id="formPaginaInicial" enctype="multipart/form-data">

            <!-- Seção Modificar Logo -->
            <div class="form-section">
                <h4>Modificar Logo</h4>
                <div class="mb-3">
                    <label for="logo" class="form-label">Escolha uma nova imagem para a Logo</label>
                    <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                </div>
            </div>

            <hr>

            <!-- Seção Modificar Banner -->
            <div class="form-section">
                <h4>Modificar Banner</h4>
                <div class="mb-3">
                    <label for="banner" class="form-label">Escolha uma nova imagem para o Banner</label>
                    <input type="file" id="banner" name="banner" class="form-control" accept="image/*">
                </div>
            </div>

            <hr>

            <!-- Seção Modificar ou Criar Novas Categorias de Agendamento -->
            <div class="form-section">
                <h4>Modificar ou Criar Categorias de Agendamento</h4>
                <div id="categoriesList">
                    <div class="category-item mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="categoryTitle1" class="form-label">Título da Categoria</label>
                                <input type="text" id="categoryTitle1" name="categories[0][title]" class="form-control" value="Consultas presenciais" placeholder="Nome da categoria">
                            </div>
                            <div class="col-md-4">
                                <label for="categoryIcon1" class="form-label">Ícone da Categoria</label>
                                <input type="text" id="categoryIcon1" name="categories[0][icon]" class="form-control" value="👨‍⚕️" placeholder="Ícone (ex: 👨‍⚕️)">
                            </div>
                            <div class="col-md-3">
                                <label for="categoryColor1" class="form-label">Cor da Categoria</label>
                                <input type="color" id="categoryColor1" name="categories[0][color]" class="form-control" value="#17a2b8">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger" onclick="removeCategory(this)">X</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary" onclick="addNewCategory()">Adicionar Nova Categoria</button>
                </div>
            </div>

            <hr>

            <!-- Seção FAQ -->
            <div class="form-section">
                <h4>Perguntas Frequentes (FAQ)</h4>
                <div id="faqList">
                    <div class="mb-3">
                        <label for="faqQuestion1" class="form-label">Pergunta 1</label>
                        <input type="text" id="faqQuestion1" name="faq[0][question]" class="form-control" value="O que é o MedExame?" placeholder="Insira a pergunta">
                    </div>
                    <div class="mb-3">
                        <label for="faqAnswer1" class="form-label">Resposta 1</label>
                        <textarea id="faqAnswer1" name="faq[0][answer]" class="form-control" rows="5" placeholder="Insira a resposta">O MedExame é um sistema que permite que clínicas se cadastrem e ofereçam serviços como exames e consultas de forma prática e eficiente.</textarea>
                    </div>
                </div>
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
                    <textarea id="infoBasicas" name="infoBasicas" class="form-control" rows="5" placeholder="Insira as informações básicas da clínica"></textarea>
                </div>
            </div>

            <hr>

            <!-- Seção QR Code -->
            <div class="form-section">
                <h4>Modificar Links do App</h4>
                <div class="mb-3">
                    <label for="playStoreLink" class="form-label">Link do App na Play Store</label>
                    <input type="url" id="playStoreLink" name="playStoreLink" class="form-control" placeholder="Insira o link do app na Play Store">
                </div>
                <div class="mb-3">
                    <label for="apkLink" class="form-label">Link do APK</label>
                    <input type="url" id="apkLink" name="apkLink" class="form-control" placeholder="Insira o link direto do APK">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <!-- SweetAlert2 para feedback visual -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Adicionar nova categoria
        function addNewCategory() {
            const categoryIndex = document.querySelectorAll('.category-item').length;
            const categoryList = document.getElementById('categoriesList');

            const newCategory = document.createElement('div');
            newCategory.classList.add('category-item', 'mb-3');
            newCategory.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label for="categoryTitle${categoryIndex}" class="form-label">Título da Categoria</label>
                        <input type="text" id="categoryTitle${categoryIndex}" name="categories[${categoryIndex}][title]" class="form-control" placeholder="Nome da categoria">
                    </div>
                    <div class="col-md-4">
                        <label for="categoryIcon${categoryIndex}" class="form-label">Ícone da Categoria</label>
                        <input type="text" id="categoryIcon${categoryIndex}" name="categories[${categoryIndex}][icon]" class="form-control" placeholder="Ícone (ex: 👨‍⚕️)">
                    </div>
                    <div class="col-md-3">
                        <label for="categoryColor${categoryIndex}" class="form-label">Cor da Categoria</label>
                        <input type="color" id="categoryColor${categoryIndex}" name="categories[${categoryIndex}][color]" class="form-control" value="#17a2b8">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onclick="removeCategory(this)">X</button>
                    </div>
                </div>
            `;

            categoryList.appendChild(newCategory);
        }

        // Adicionar nova pergunta FAQ
        function addFaqQuestion() {
            const faqIndex = document.querySelectorAll('#faqList .mb-3').length / 2;
            const faqList = document.getElementById('faqList');

            const newFaq = document.createElement('div');
            newFaq.innerHTML = `
                <div class="mb-3">
                    <label for="faqQuestion${faqIndex}" class="form-label">Pergunta ${faqIndex + 1}</label>
                    <input type="text" id="faqQuestion${faqIndex}" name="faq[${faqIndex}][question]" class="form-control" placeholder="Insira a pergunta">
                </div>
                <div class="mb-3">
                    <label for="faqAnswer${faqIndex}" class="form-label">Resposta ${faqIndex + 1}</label>
                    <textarea id="faqAnswer${faqIndex}" name="faq[${faqIndex}][answer]" class="form-control" rows="5" placeholder="Insira a resposta"></textarea>
                </div>
            `;

            faqList.appendChild(newFaq);
        }

        // Remover categoria
        function removeCategory(button) {
            button.closest('.category-item').remove();
        }

        // Envio do formulário via AJAX
        document.getElementById('formPaginaInicial').addEventListener('submit', function(e) {
            e.preventDefault(); // Impede o envio tradicional do formulário

            const formData = new FormData(this); // Cria um objeto FormData com os dados do formulário

            fetch('{{ route("admin.homepage.save") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Adiciona o token CSRF para segurança
                }
            })
            .then(response => response.json()) // Converte a resposta para JSON
            .then(data => {
                if (data.success) {
                    Swal.fire('Sucesso!', 'Configurações salvas com sucesso!', 'success');
                } else {
                    Swal.fire('Erro!', 'Erro ao salvar as configurações.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Erro!', 'Ocorreu um erro ao enviar os dados.', 'error');
            });
        });
    </script>
@endsection