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

            <!-- Seção Modificar Banner -->
            <div class="form-section">
                <h4>Modificar Banner</h4>
                <div class="mb-3">
                    <label for="banner" class="form-label">Escolha uma nova imagem para o Banner</label>
                    <input type="file" id="banner" name="banner" class="form-control" accept="image/*">
                </div>
            </div>

            <hr>

            <!-- Seção Perguntas Frequentes (FAQ) -->
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

            <!-- Seção Modificar Links do App -->
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
        // Função para adicionar nova pergunta FAQ
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
