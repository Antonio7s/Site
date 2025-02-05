<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Inicial - MedExame</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* MENU E FOOTER */
            body {
                overflow-x: hidden; /* */
                font-family: Arial, sans-serif;
                background-color: #f0f8ff;
                color: #333;
            }
            header {
                background-color: #007bff;
                padding: 10px 0;
                color: white;
            }
            .logo {
                font-size: 24px;
                font-weight: bold;
            }
            .nav-link {
                color: white;
                font-weight: 500;
                text-decoration: none;
                margin: 0 10px;
            }
            .nav-link:hover {
                text-decoration: underline;
            }
            .banner {
                margin-top: 20px;
                background-color: #6aed5c;
                height: 300px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 32px;
                color: white;
                border-radius: 10px;
            }
            .info-section {
                margin-top: 20px;
                padding: 20px;
                background-color: #ffffff;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            footer {
                background-color: #007bff;
                color: white;
                text-align: center;
                padding: 40px 0;
            }
            footer .social-icons a {
                font-size: 28px;
                margin: 0 10px;
                text-decoration: none;
                transition: transform 0.2s ease, color 0.2s ease;
            }
            footer .social-icons a:hover {
                transform: scale(1.2);
                filter: brightness(1.2);
            }
            .facebook {
                color: #2d3270;
            }
            .instagram {
                color: #E4405F;
            }
            .twitter {
                color: black;
            }
            .whatsapp {
                color: #25D366;
            }
    </style>
</head>
<body>


<!-- Cabeçalho -->
    <header class="container-fluid">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="/" class="logo" style="text-decoration: none; color: inherit;">Minha Logo </a>
            </div>
            <nav class="d-flex">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="menuCliente" data-bs-toggle="dropdown" aria-expanded="false">
                        Sou Paciente
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuCliente">
                        <li><a class="dropdown-item" href="/login-paciente">Fazer Login</a></li>
                        <li><a class="dropdown-item" href="em-construcao">Consulta</a></li>
                        <li><a class="dropdown-item" href="em-construcao">Exames</a></li>
                        <li><a class="dropdown-item" href="em-construcao">Médicos</a></li>
                        <li><a class="dropdown-item" href="fale-conosco">Fale Conosco</a></li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="menuProfissional" data-bs-toggle="dropdown" aria-expanded="false">
                        Sou Profissional de saúde
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuProfissional">
                        <li><a class="dropdown-item" href="/login-clinica">Fazer Login</a></li>
                        <li><a class="dropdown-item" href="em-construcao">Quero ser Parceiro</a></li>
                        <li><a class="dropdown-item" href="fale-conosco">Fale Conosco</a></li>
                    </ul>
                </div>
                <a href="politicas-de-privacidade" class="nav-link">Política de Privacidade</a>
                <a href="sobre-a-medexame" class="nav-link">Sobre a Medexame</a>
            </nav>


            <!-- Exibir o estado selecionado -->
            <div>
                <span id="estadoSelecionado" class="badge bg-info">Estado: Não Selecionado</span>
                <a href="redirecionar-login" class="btn btn-outline-light btn-sm">Login</a>
                <a href="cadastro" class="btn btn-light btn-sm">Cadastro</a>

            </div>
        </div>
    </header>



    <!-- Modal de Seleção de Estado -->
    <div class="modal fade" id="estadoModal" tabindex="-1" aria-labelledby="estadoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="estadoModalLabel">Qual seu estado?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="estado" class="form-select" onchange="mostrarEstado()">
                        <option value="" disabled selected>Selecione um Estado</option>
                        <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="PR">Paraná</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SE">Sergipe</option>
                                <option value="SP">São Paulo</option>
                                <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Verificar se há um estado armazenado ao carregar a página
        window.onload = function() {
            const estadoArmazenado = localStorage.getItem('estadoSelecionado');

            if (!estadoArmazenado) {
                // Se não houver estado armazenado, abrir o modal
                var myModal = new bootstrap.Modal(document.getElementById('estadoModal'));
                myModal.show();
            } else {
                // Se houver estado armazenado, exibir no cabeçalho
                document.getElementById('estadoSelecionado').textContent = 'Estado: ' + estadoArmazenado;
            }

            // Adicionar evento de clique no estado exibido no cabeçalho
            document.getElementById('estadoSelecionado').addEventListener('click', function() {
                var myModal = new bootstrap.Modal(document.getElementById('estadoModal'));
                myModal.show();
            });
        };

        // Função para mostrar o estado selecionado no cabeçalho, armazenar no localStorage e fechar o modal
        function mostrarEstado() {
            const estado = document.getElementById('estado').value;
            const estadoTexto = estado ? estado : 'Não Selecionado';

            // Armazenar o estado no localStorage
            localStorage.setItem('estadoSelecionado', estadoTexto);

            // Exibir o estado no cabeçalho
            document.getElementById('estadoSelecionado').textContent = 'Estado: ' + estadoTexto;

            // Fechar o modal após selecionar o estado
            var myModal = bootstrap.Modal.getInstance(document.getElementById('estadoModal'));
            myModal.hide();
        }
    </script>

    <!-- Incluir o FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


    <!-- Conteúdo da página -->
    <main>

        @yield('content') <!-- Aqui será inserido o conteúdo da página -->

    </main>

    <!-- Rodapé -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="fw-bold">Medexame</h4>
                    <p>CNPJ:</p>
                    <p>Medexame</p>
                    <p>Informações úteis sobre a Medexame podem ser adicionadas aqui.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4 class="fw-bold">Informações</h4>
                    <p>Espaço em branco para preenchimento futuro.</p>
                    <p>Espaço em branco.</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <h4 class="fw-bold">Siga a gente nas Redes Sociais:</h4>
                    <div class="d-flex justify-content-center social-icons">
                        <a href="#" class="mx-2 facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="mx-2 instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="mx-2 twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="mx-2 whatsapp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <p>© 2025 Medexame. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap and Font Awesome Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>
</html>