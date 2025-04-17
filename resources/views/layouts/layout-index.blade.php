<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Adicionado para o logout -->
    <title>Site Inicial - MedExame</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Estilos personalizados */
        body {
            overflow-x: hidden;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            min-height: 100vh; /* Garante que o body ocupe pelo menos a altura da tela */
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #007bff;
            padding: 10px 0;
            color: white;
            position: relative; /* Adicionado para criar contexto de empilhamento */
            z-index: 2000;      /* Garante que o cabeçalho (e seus dropdowns) fique acima do banner */
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-right: auto; /* Move a logo para a esquerda */
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
            margin-top: auto; /* Mantém o rodapé no final da página */
        }
        footer .social-icons a {
            font-size: 24px; /* Reduz o tamanho dos ícones */
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
        #userInfo, #clinicInfo {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
        }
        #userPhoto, #clinicPhoto {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        /* Aumentado o z-index para os dropdowns */
        #userDropdown, #clinicDropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 2100;
        }
        #userDropdown a, #clinicDropdown a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }
        #userDropdown a:hover, #clinicDropdown a:hover {
            background-color: #f8f9fa;
        }
        /* Responsividade da barra de estados */
        .estado-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        @media (max-width: 576px) {
            .estado-container {
                margin-bottom: 10px;
            }
            #estadoSelecionado {
                font-size: 16px;
            }
        }

        .user-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .logo {
                font-size: 20px;
            }
            .nav-link {
                margin: 0 5px;
                font-size: 14px;
            }
            .banner {
                font-size: 24px;
                height: 200px;
            }
            .info-section {
                padding: 15px;
            }
            footer .social-icons a {
                font-size: 20px; /* Reduz o tamanho dos ícones em telas menores */
            }
            .user-container {
                flex-direction: column;
                align-items: flex-end;
            }
            #userInfo, #clinicInfo {
                margin-top: 10px;
            }
            /* Aumentando o tamanho da fonte dos menus específicos */
            .nav-link, 
            .dropdown-toggle {
                font-size: 17px; /* Aumentado para 17px */
            }
        }

        @media (max-width: 576px) {
            .logo {
                font-size: 18px;
            }
            .nav-link {
                font-size: 17px; /* Mantendo 17px para melhor visibilidade */
            }
            .banner {
                font-size: 20px;
                height: 150px;
            }
            .info-section {
                padding: 10px;
            }
            footer .social-icons a {
                font-size: 18px; /* Reduz ainda mais o tamanho dos ícones */
            }
            .user-container {
                align-items: center;
            }
        }
        
        /* Nova regra: Centralizar o modal em dispositivos móveis */
        @media (max-width: 576px) {
            #estadoModal .modal-dialog {
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        }
    </style>
</head>
<body>

<!-- Cabeçalho -->
<header>
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <!-- Logo -->
        <div class="logo">
            <a href="/" class="logo" style="text-decoration: none; color: inherit;">
                <img src="https://i.postimg.cc/mhK2Fhr6/logomed.png" alt="Logo" style="max-width: 150px; height: auto;">
            </a>
        </div>

        <!-- Estado e Informações do Usuário/Clínica -->
        <div class="user-container">
            <div class="estado-container">
                <span id="estadoSelecionado" class="badge bg-info" onclick="abrirModalEstado()">Estado: Não Selecionado</span>
            </div>

            @if(auth()->guard('clinic')->check())
                {{-- Usuário autenticado como clínica --}}
                <div id="clinicInfo">
                    <img id="clinicPhoto" src="{{ !empty(auth()->guard('clinic')->user()->photo_url) ? auth()->guard('clinic')->user()->photo_url : asset('images/icone-usuario.png') }}" alt="Foto da Clínica">
                    <span id="clinicName">{{ auth()->guard('clinic')->user()->name }}</span>
                    <div id="clinicDropdown">
                        <a href="{{ route('admin-clinica.dashboard.index')}}" class="dropdown-item">Página da Clínica</a>
                        <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('clinic-logout-form').submit();">Sair</a>
                        <!-- Formulário oculto -->
                        <form id="clinic-logout-form" action="{{ route('logout2') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @elseif(auth()->guard('web')->check())
                {{-- Usuário autenticado como usuário comum --}}
                <div id="userInfo">
                    <img id="userPhoto" src="{{ !empty(auth()->guard('web')->user()->photo_url) ? auth()->guard('web')->user()->photo_url : asset('images/icone-usuario.png') }}" alt="Foto do Usuário">
                    <span id="userName">{{ auth()->guard('web')->user()->name }}</span>
                    <div id="userDropdown">
                        <a href="/perfil">Página do Usuário</a>
                        <a href="javascript:void(0)" onclick="logout()">Logout</a>
                    </div>
                </div>
            @else
                {{-- Usuário não autenticado --}}
                <div id="authButtons" class="d-flex align-items-center">
                    <a href="{{ route('login') }}" id="loginButton" class="btn btn-outline-light btn-sm me-2">Login</a>
                    <a href="{{ route('register') }}" id="registerButton" class="btn btn-light btn-sm">Cadastro</a>
                </div>
            @endif
        </div>

        <!-- Menu de Navegação -->
        <nav class="navbar navbar-expand-lg navbar-dark w-100" style="background-color: #007bff;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100" id="navbarNav">
                <a href="sobre-a-medexame" class="nav-link">Sobre a Medexame</a>
                <a href="politicas-de-privacidade" class="nav-link">Aviso de Privacidade</a>
                <div class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" id="menuCliente" data-bs-toggle="dropdown" aria-expanded="false">
                        Sou Cliente
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuCliente">
                        <li><a class="dropdown-item" href="{{ route('register') }}">Fazer Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.fale-conosco') }}">Fale Conosco</a></li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" id="menuProfissional" data-bs-toggle="dropdown" aria-expanded="false">
                        Sou Profissional de Saúde
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuProfissional">
                        <li><a class="dropdown-item" href="{{ route('login2') }}">Fazer Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register2') }}">Fazer Cadastro</a></li>
                        <!-- <li><a class="dropdown-item" href="em-construcao">Quero ser Parceiro</a></li> -->
                        <li><a class="dropdown-item" href="fale-conosco">Fale Conosco</a></li>
                    </ul>
                </div>
            </div>
        </nav>
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
                <select id="estado" class="form-select">
                    <option value="" disabled selected>Selecione um Estado</option>
                    ...
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="salvarEstado()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Incluir o FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- Conteúdo da página -->
<main>
    @yield('content') <!-- Aqui será inserido o conteúdo da página -->
</main>

<!-- Rodapé -->
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold">MedExame</h4>
                <p>CNPJ: 53.270.181/0001-32</p>
                <p>Telefone para contato no WhatsApp: 44 – 998453216</p>
                <p>Agendamento de Serviços de Saúde com facilidade e os melhores preços!</p>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold">Informações</h4>
                <p>Na MedExame, você acessa uma rede de serviços de saúde com os melhores preços e atendimento de qualidade.</p>
                <p>Veja como é simples:</p>
                <ol>
                    <li>Acesse nosso site ou aplicativo</li>
                    <li>Escolha o serviço que precisa (consulta, exame, vacina, odontologia, cirurgia ou check-up)</li>
                    <li>Compare preços, locais e datas disponíveis</li>
                    <li>Selecione o profissional e agende com poucos cliques</li>
                    <li>Receba a confirmação e vá até o local escolhido no dia marcado</li>
                    <li>Tudo rápido, seguro e sem burocracia.</li>
                </ol>
            </div>
            <div class="col-md-4 mb-4 text-center">
                <h4 class="fw-bold">Siga-nos nas Redes Sociais:</h4>
                <div class="d-flex justify-content-center flex-wrap social-icons">
                    <a href="https://www.facebook.com/profile.php?id=100081021690578" class="mx-2 facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/med.exame/" class="mx-2 instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/554188322656" class="mx-2 whatsapp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <p>© 2025 MedExame. Todos os direitos reservados.</p>
    </div>
</footer>

<!-- Bootstrap and Font Awesome Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Função para abrir o modal de seleção de estado
    function abrirModalEstado() {
        const estadoModal = new bootstrap.Modal(document.getElementById('estadoModal'));
        estadoModal.show();
    }

    // Função para mostrar o estado selecionado
    function mostrarEstado() {
        const estadoSelecionado = document.getElementById('estado').value;
        const estadoBadge = document.getElementById('estadoSelecionado');
        if (estadoSelecionado) {
            estadoBadge.textContent = `Estado: ${estadoSelecionado}`;
            localStorage.setItem('estadoSelecionado', estadoSelecionado); // Salva o estado no localStorage
        } else {
            estadoBadge.textContent = 'Estado: Não Selecionado';
        }
    }

    // Função para salvar o estado selecionado e fechar o modal
    function salvarEstado() {
        mostrarEstado();
        const estadoModal = bootstrap.Modal.getInstance(document.getElementById('estadoModal'));
        estadoModal.hide();
    }

    // Verifica se o estado já foi selecionado ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const estadoSalvo = localStorage.getItem('estadoSelecionado');
        const estadoBadge = document.getElementById('estadoSelecionado');
        if (estadoSalvo) {
            estadoBadge.textContent = `Estado: ${estadoSalvo}`;
        } else {
            abrirModalEstado();
        }
    });

    // Mostrar/ocultar dropdown do usuário/clínica
    document.getElementById('userInfo')?.addEventListener('click', function() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.getElementById('clinicInfo')?.addEventListener('click', function() {
        const dropdown = document.getElementById('clinicDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Fechar dropdown ao clicar fora
    document.addEventListener('click', function(event) {
        const userInfo = document.getElementById('userInfo');
        const clinicInfo = document.getElementById('clinicInfo');
        const userDropdown = document.getElementById('userDropdown');
        const clinicDropdown = document.getElementById('clinicDropdown');
        if (userInfo && !userInfo.contains(event.target)) {
            userDropdown.style.display = 'none';
        }
        if (clinicInfo && !clinicInfo.contains(event.target)) {
            clinicDropdown.style.display = 'none';
        }
    });

    // Função de logout
    function logout() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            }
        }).catch(error => {
            console.error('Erro ao fazer logout:', error);
        });
    }
</script>

</body>
</html>
