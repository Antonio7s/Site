@extends('layouts.layout-index')

@section('content')
    <head>
        <!-- Inclua as bibliotecas necessárias -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

        <!-- CSS TEXTO DINÂMICO PESQUISA -->
        <style>
            .search-title {
                font-size: 1.5rem;
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
            }
            .typed-effect {
                color: #007bff;
                font-weight: bold;
            }
        </style>

        <!-- ESTILO DOS CARDS E BARRA DE BUSCA -->
        <style>
            .custom-search-bar {
                max-width: 900px;
                margin: 0 auto;
            }
            .custom-search-bar input {
                border-radius: 50px 0 0 50px;
                padding: 15px;
                font-size: 1.2rem;
            }
            .custom-search-bar button {
                border-radius: 0 50px 50px 0;
                padding: 15px 25px;
                font-size: 1.2rem;
            }
            .custom-search-bar .input-group {
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .custom-search-bar .form-select {
                border-radius: 50px;
                margin-right: 10px;
                padding: 6px 10px;
                font-size: 0.8rem;
                width: 15%;
            }
        </style>

        <!-- CSS DOS CARDS -->
        <style>
            .card {
                border-radius: 15px;
                text-align: center;
                padding: 20px;
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .card:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .icon {
                font-size: 2rem;
                margin-bottom: 10px;
            }
            .promo-section {
                background-color: #f4f3ff;
                border-radius: 15px;
                padding: 30px;
                text-align: center;
                color: #4a3dbd;
                font-family: Arial, sans-serif;
            }
            .promo-section h1 {
                font-size: 1.8rem;
                font-weight: bold;
                margin-top: 15px;
                margin-bottom: 10px;
            }
            .promo-section p {
                font-size: 1rem;
                margin-bottom: 20px;
                color: #6a5cdb;
            }
            .promo-logo {
                background-color: #4a3dbd;
                color: white;
                font-size: 1.2rem;
                font-weight: bold;
                width: 120px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px;
            }
            .qr-code {
                margin: 20px 0;
                max-width: 200px;
                max-height: 200px;
                width: 100%;
                height: auto;
                object-fit: contain;
            }
            .store-buttons img {
                width: 120px;
                margin: 5px;
            }
        </style>

        <!-- CSS DO PARALLAX -->
        <style>
            .parallax {
                position: relative;
                overflow: hidden;
            }
            .parallax img {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                height: auto;
                object-fit: cover;
                will-change: transform;
                transition: transform 0.3s ease;
            }
            .counter-section {
                padding: 100px 0;
                text-align: center;
                background-color: #C0C0C0 !important;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                transition: background-color 0.3s, opacity 0.3s ease;
            }
            .counter-item {
                font-size: 4rem;
                font-weight: 600;
                color: rgba(0,0,0,0.42);
                margin-bottom: 10px;
                transition: transform 0.3s ease-in-out;
            }
            .counter-section p {
                font-size: 1.2rem;
                color: #f8f9fa;
                margin-top: 10px;
            }
            .icon {
                font-size: 50px;
                margin-bottom: 15px;
                color: #fff;
            }
            .content {
                padding: 100px 0;
            }
            .section-text {
                margin-bottom: 50px;
            }
            .text-filler {
                font-size: 1.1rem;
                color: #888;
                text-align: center;
            }
        </style>

        <!-- CSS CARDS -->
        <style>
            .servicos-clinica {
                background-color: #f8f9fa;
                padding: 2rem 0;
                border-radius: 15px;
            }
            .scroll-horizontal {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 1rem;
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
            }
            .servico-item {
                background: white;
                border: 1px solid #e0e0e0;
                border-radius: 10px;
                padding: 1.5rem;
                min-width: 80px;
                margin: 0 8px;
                transition: all 0.3s ease;
                flex-shrink: 0;
                text-align: center;
                color: #2a3f54;
            }
            .servico-item:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 15px rgba(42,63,84,0.1);
                border-color: #007bff;
            }
            .scroll-horizontal::-webkit-scrollbar {
                height: 8px;
                background: #f1f1f1;
            }
            .scroll-horizontal::-webkit-scrollbar-thumb {
                background: #007bff;
                border-radius: 4px;
            }
            .servico-item i {
                font-size: 1.8rem;
                color: #007bff;
                margin-bottom: 0.8rem;
                display: block;
            }
            @media (max-width: 992px) {
                .banner.container,
                .info-section.container {
                    width: 100% !important;
                    padding: 0 15px;
                }
                .custom-search-bar {
                    max-width: 100%;
                }
                .promo-section {
                    width: 95%;
                }
            }
            @media (max-width: 768px) {
                .search-title {
                    font-size: 1.3rem;
                }
                .custom-search-bar input {
                    font-size: 1rem;
                    padding: 10px;
                }
                .custom-search-bar button {
                    font-size: 1rem;
                    padding: 10px 20px;
                }
                .counter-item {
                    font-size: 3rem;
                }
                .promo-logo {
                    width: 100px;
                    height: 40px;
                    font-size: 1rem;
                }
                .promo-section h1 {
                    font-size: 1.5rem;
                }
                .promo-section p {
                    font-size: 0.9rem;
                }
                .qr-code {
                    max-width: 120px;
                }
                .servico-item {
                    min-width: 60px;
                    padding: 1rem;
                    font-size: 0.9rem;
                }
            }
            @media (max-width: 480px) {
                .banner.container {
                    min-height: 200px;
                }
                .typed-effect {
                    font-size: 1.2rem;
                }
                .custom-search-bar input,
                .custom-search-bar button {
                    font-size: 0.9rem;
                    padding: 8px;
                }
                .counter-section {
                    padding: 50px 0;
                }
                .counter-item {
                    font-size: 2.5rem;
                }
                .servicos-clinica {
                    padding: 1rem 0;
                }
                .promo-section {
                    padding: 15px;
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>
        <!-- Banner: Exibe o banner definido na tabela homepage_settings -->
        <div class="banner container text-center p-0" style="min-height: 300px;">
            @if(!empty($homepageSettings->banner_path))
                <img src="{{ asset($homepageSettings->banner_path) }}" alt="Banner" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <p>Nenhum banner configurado.</p>
            @endif
        </div>

        <!-- Informações Básicas -->
        <div class="info-section container mt-4">
            <h2>Informações Básicas</h2>
            <p>Aqui você pode adicionar informações sobre o site, descrição de serviços ou qualquer outro conteúdo relevante.</p>
            <div class="container servicos-clinica mt-5">
                <div class="scroll-horizontal">
                    <div class="servico-item">
                        <i class="fas fa-calendar-check"></i>
                        <h5 class="mb-0 mt-2">Agendar <br> Consultas</h5>
                    </div>
                    <div class="servico-item">
                        <i class="fas fa-microscope"></i>
                        <h5 class="mb-0 mt-2">Agendar <br> Exames</h5>
                    </div>
                    <div class="servico-item">
                        <i class="fas fa-syringe"></i>
                        <h5 class="mb-0 mt-2">Agendar <br> Vacinas</h5>
                    </div>
                    <div class="servico-item">
                        <i class="fas fa-tooth"></i>
                        <h5 class="mb-0 mt-2">Odontologia</h5>
                    </div>
                    <div class="servico-item">
                        <i class="fas fa-procedures"></i>
                        <h5 class="mb-0 mt-2">Cirurgias</h5>
                    </div>
                    <div class="servico-item">
                        <i class="fas fa-stethoscope"></i>
                        <h5 class="mb-0 mt-2">Check-up <br> Completo</h5>
                    </div>
                    <div class="servico-item">
                        <i class="fas fa-video"></i>
                        <h5 class="mb-0 mt-2">Atendimento <br> Online</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barra de Busca e Efeito de Texto -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <p class="search-title">
                        Pesquise <span class="typed-effect"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Barra de Busca -->
        <div class="container mt-5">
            <div class="row justify-content-center mb-4">
                <div class="custom-search-bar">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Pesquisar..." aria-label="Pesquisar">
                        <a href="busca" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Especialidades Mais Buscadas -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3 class="text-center mb-4">Especialidades Mais Buscadas</h3>
                <div class="row g-4">
                    <!-- Card 1 -->
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-heartbeat fa-3x text-danger mb-3"></i>
                                <h5 class="card-title">Cardiologia</h5>
                                <p class="card-text">Cuide do seu coração com os melhores especialistas.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-brain fa-3x text-info mb-3"></i>
                                <h5 class="card-title">Neurologia</h5>
                                <p class="card-text">Especialistas em saúde do sistema nervoso.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-baby fa-3x text-warning mb-3"></i>
                                <h5 class="card-title">Pediatria</h5>
                                <p class="card-text">Cuidados especiais para os pequenos.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-3">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-tooth fa-3x text-success mb-3"></i>
                                <h5 class="card-title">Odontologia</h5>
                                <p class="card-text">Sorria com saúde e confiança.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção Parallax com Animação -->
        <div class="parallax mt-5">
            <div class="container">
                <div class="counter-section" id="counter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="icon">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div class="counter-item" id="clientes">0</div>
                            <p>Clientes Cadastrados</p>
                        </div>
                        <div class="col-md-3">
                            <div class="icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="counter-item" id="clinicas">0</div>
                            <p>Clínicas Parceiras</p>
                        </div>
                        <div class="col-md-3">
                            <div class="icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="counter-item" id="medicos">0</div>
                            <p>Médicos Ativos</p>
                        </div>
                        <div class="col-md-3">
                            <div class="icon">
                                <i class="bi bi-briefcase-medical"></i>
                            </div>
                            <div class="counter-item" id="especialidades">0</div>
                            <p>Especialidades Oferecidas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção Promo App -->
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="promo-section" style="background-color: #f0f7ff; border: 2px solid #333; border-radius: 15px; padding: 20px; color: black; text-align: center; width: 90%; max-width: 600px; overflow: hidden;">
                <!-- Logo do App -->
                <div class="promo-logo">MedExame</div>
                <!-- Título -->
                <h1>Baixe nosso App</h1>
                <!-- Descrição -->
                <p>Marque suas consultas rapidamente de qualquer lugar.</p>
                <!-- QR Code -->
                <div class="qr-code" style="margin: 20px auto; width: 150px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png" alt="QR Code" class="img-fluid">
                </div>
                <!-- Botão para Google Play -->
                <div style="margin-top: 20px; background-color: #f0f7ff; padding: 15px; border-radius: 10px;">
                    <a href="https://play.google.com/store/apps/details?id=com.seuapp" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" style="width: 180px;">
                    </a>
                </div>
            </div>
        </div>

        <!-- Accordion de Perguntas Frequentes -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Perguntas Frequentes</h2>
            <div class="accordion" id="faqAccordion">
                <!-- Pergunta 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            O que é o MedExame?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            O MedExame é um sistema que permite que clínicas se cadastrem e ofereçam serviços como exames e consultas de forma prática e eficiente.
                        </div>
                    </div>
                </div>
                <!-- Pergunta 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Como posso me cadastrar no sistema?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Para se cadastrar, basta acessar a página inicial, clicar no botão "Cadastro" e preencher o formulário com seus dados.
                        </div>
                    </div>
                </div>
                <!-- Pergunta 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Quais serviços posso oferecer?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Você pode oferecer serviços como consultas médicas, exames laboratoriais, e outros procedimentos dependendo das especialidades da sua clínica.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCRIPTS -->
        <script>
            // Função para animar os números
            function animateCounter(id, target) {
                let start = 0;
                const duration = 2000;
                const stepTime = Math.abs(Math.floor(duration / target));
                const counter = document.getElementById(id);
                const interval = setInterval(() => {
                    start += 1;
                    counter.innerText = start;
                    if (start >= target) {
                        clearInterval(interval);
                    }
                }, stepTime);
            }

            // Detectar visibilidade usando IntersectionObserver
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const counterSection = document.getElementById('counter-section');
                    if (entry.isIntersecting) {
                        animateCounter('clientes', 1200);
                        animateCounter('clinicas', 50);
                        animateCounter('medicos', 150);
                        animateCounter('especialidades', 30);
                        counterSection.style.backgroundColor = '#FF6347';
                        counterSection.style.opacity = '1';
                    } else {
                        counterSection.style.backgroundColor = '#FF6347';
                        counterSection.style.opacity = '0.3';
                    }
                });
            }, { threshold: 0.5 });
            observer.observe(document.querySelector('.counter-section'));

            // Efeito Parallax
            window.addEventListener('scroll', function() {
                const scrollPosition = window.pageYOffset;
                const parallaxImage = document.querySelector('.parallax img');
                if (parallaxImage) {
                    parallaxImage.style.transform = `translateY(${scrollPosition * 0.2}px)`;
                }
            });
        </script>

        <script>
            // Configuração do Typed.js
            var options = {
                strings: ["uma especialidade", "uma clínica", "um exame", "uma vacina"],
                typeSpeed: 60,
                backSpeed: 40,
                backDelay: 1500,
                loop: true
            };
            var typed = new Typed(".typed-effect", options);
        </script>
    </body>
@endsection