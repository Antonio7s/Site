@extends('layouts.layout-index')

@section('content')
    <!-- Custom CSS for Homepage -->
    <style>
        /* Typed.js Dynamic Text */
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

        /* Search Bar and Cards */
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

        /* Service Cards */
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

        /* Promo Section */
        .promo-section {
            background-color: #f4f3ff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            color: #4a3dbd;
            font-family: Arial, sans-serif;
            margin-bottom: 1rem;
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

        /* Parallax Section */
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
            transition: transform 0.3s ease;
        }

        /* Counter Section */
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

        /* Clinic Services Scroll */
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

        /* Ensure dropdowns appear above other elements */
        .dropdown-menu {
            z-index: 9999 !important;
        }
    </style>

    <!-- Banner Dinâmico -->
    <div class="banner container text-center p-0" style="min-height: 300px; position: relative;">
        <img
            src="{{ asset('images/banners/default-banner.jpg') }}"
            alt="Banner Padrão"
            class="img-fluid w-100"
            style="min-height:300px; object-fit:cover;"
        >
        @if(!empty($homepageSettings->banner_path))
            <img
                src="{{ asset($homepageSettings->banner_path) }}"
                alt="Banner"
                class="position-absolute top-0 start-0 w-100 h-100"
                style="object-fit:cover;"
            >
        @endif
    </div>

    <!-- Informações Básicas -->
    <div class="info-section container mt-4">
        <h2>Informações Básicas</h2>
        <p>
            Aqui você pode adicionar informações sobre o site, descrição de serviços ou qualquer outro conteúdo relevante.
            @if(!empty($homepageSettings->info_basicas))
                {!! $homepageSettings->info_basicas !!}
            @endif
        </p>
        <div class="container servicos-clinica mt-5">
            <div class="scroll-horizontal">
                <a href="{{ url('Busca') }}?q=Consultas" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-calendar-check"></i>
                    <h5 class="mb-0 mt-2">Agendar <br> Consultas</h5>
                </a>
                <a href="{{ url('Busca') }}?q=Exames" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-microscope"></i>
                    <h5 class="mb-0 mt-2">Agendar <br> Exames</h5>
                </a>
                <a href="{{ url('Busca') }}?q=Vacinas" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-syringe"></i>
                    <h5 class="mb-0 mt-2">Agendar <br> Vacinas</h5>
                </a>
                <a href="{{ url('Busca') }}?q=Odontologia" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-tooth"></i>
                    <h5 class="mb-0 mt-2">Odontologia<br>&nbsp;</h5>
                </a>
                <a href="{{ url('Busca') }}?q=Cirurgias" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-procedures"></i>
                    <h5 class="mb-0 mt-2">Cirurgias<br>&nbsp;</h5>
                </a>
                <a href="{{ url('Busca') }}?q=Check-up" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-stethoscope"></i>
                    <h5 class="mb-0 mt-2">Check-up <br> Completo</h5>
                </a>
                <a href="{{ url('Busca') }}?q=Online" class="servico-item text-decoration-none text-inherit">
                    <i class="fas fa-video"></i>
                    <h5 class="mb-0 mt-2">Atendimento <br> Online</h5>
                </a>
            </div>
        </div>
    </div>

    <!-- Barra de Busca e Efeito de Texto -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <p class="search-title">Pesquise <span class="typed-effect"></span></p>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center mb-4">
            <div class="custom-search-bar w-100">
                <form action="{{ url('Busca') }}" method="GET">
                    <div class="input-group">
                        <input
                            type="text"
                            name="q"
                            class="form-control form-control-lg"
                            placeholder="Pesquisar..."
                            aria-label="Pesquisar"
                            value="{{ request()->query('q') }}"
                        >
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Especialidades Mais Buscadas -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="text-center mb-4">Especialidades Mais Buscadas</h3>
            <div class="row g-4">
                <div class="col-md-3">
                    <a href="{{ url('Busca') }}?q=Cardiologia" class="text-decoration-none text-inherit">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-heartbeat fa-3x text-danger mb-3"></i>
                                <h5 class="card-title">Cardiologia</h5>
                                <p class="card-text">Cuide do seu coração com os melhores especialistas.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('Busca') }}?q=Neurologia" class="text-decoration-none text-inherit">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-brain fa-3x text-info mb-3"></i>
                                <h5 class="card-title">Neurologia</h5>
                                <p class="card-text">Especialistas em saúde do sistema nervoso.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('Busca') }}?q=Pediatria" class="text-decoration-none text-inherit">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-baby fa-3x text-warning mb-3"></i>
                                <h5 class="card-title">Pediatria</h5>
                                <p class="card-text">Cuidados especiais para os pequenos.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('Busca') }}?q=Odontologia" class="text-decoration-none text-inherit">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-tooth fa-3x text-success mb-3"></i>
                                <h5 class="card-title">Odontologia</h5>
                                <p class="card-text">Sorria com saúde e confiança.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção Parallax com Contadores -->
    <div class="parallax mt-5">
        <div class="container">
            <div class="counter-section" id="counter-section">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="icon"><i class="bi bi-person-check"></i></div>
                        <div class="counter-item" id="clientes">0</div>
                        <p>Clientes Cadastrados</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="icon"><i class="bi bi-building"></i></div>
                        <div class="counter-item" id="clinicas">0</div>
                        <p>Clínicas Parceiras</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="icon"><i class="bi bi-person"></i></div>
                        <div class="counter-item" id="medicos">0</div>
                        <p>Médicos Ativos</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="icon"><i class="bi bi-briefcase-medical"></i></div>
                        <div class="counter-item" id="especialidades">0</div>
                        <p>Especialidades Oferecidas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ e Promo App -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Perguntas Frequentes</h2>
                <div class="accordion" id="faqAccordion">
                    @forelse($faqs as $index => $faqItem)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading{{ $index }}">
                                <button
                                    class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapse{{ $index }}"
                                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                    aria-controls="faqCollapse{{ $index }}"
                                >
                                    {{ $faqItem->question }}
                                </button>
                            </h2>
                            <div
                                id="faqCollapse{{ $index }}"
                                class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                aria-labelledby="faqHeading{{ $index }}"
                                data-bs-parent="#faqAccordion"
                            >
                                <div class="accordion-body">
                                    {{ $faqItem->answer }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingDefault">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseDefault" aria-expanded="true" aria-controls="faqCollapseDefault">
                                    O que é o MedExame?
                                </button>
                            </h2>
                            <div id="faqCollapseDefault" class="accordion-collapse collapse show" aria-labelledby="faqHeadingDefault" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    O MedExame é um sistema que permite que clínicas se cadastrem e ofereçam serviços como exames e consultas de forma prática e eficiente.
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <div class="promo-section" style="background-color: #f0f7ff; border: 2px solid #333; border-radius: 15px; padding: 20px; color: black; text-align: center;">
                    <div class="promo-logo">MedExame</div>
                    <h1>Baixe nosso App</h1>
                    <p>Marque suas consultas rapidamente de qualquer lugar.</p>
                    <div class="store-buttons" style="margin-top: 20px;">
                        <a href="{{ $homepageSettings->play_store_link ?? 'https://play.google.com/store/apps/details?id=com.seuapp' }}" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JS for Homepage -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        // Prevent dropdown overflow
        var dropdownTriggerList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownTriggerList.map(function(el) {
            return new bootstrap.Dropdown(el, {
                popperConfig: function(defaultConfig) {
                    defaultConfig.options.modifiers.push({
                        name: 'preventOverflow',
                        options: { boundary: document.body }
                    });
                    return defaultConfig;
                }
            });
        });

        // Animate counters
        function animateCounter(id, target) {
            let start = 0;
            const duration = 2000;
            const stepTime = Math.abs(Math.floor(duration / target));
            const counter = document.getElementById(id);
            const interval = setInterval(() => {
                start++;
                counter.innerText = start;
                if (start >= target) clearInterval(interval);
            }, stepTime);
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const section = document.getElementById('counter-section');
                if (entry.isIntersecting) {
                    animateCounter('clientes', 1200);
                    animateCounter('clinicas', 50);
                    animateCounter('medicos', 150);
                    animateCounter('especialidades', 30);
                    section.style.backgroundColor = '#FF6347';
                    section.style.opacity = '1';
                } else {
                    section.style.opacity = '0.3';
                }
            });
        }, { threshold: 0.5 });
        observer.observe(document.querySelector('.counter-section'));

        // Parallax scroll
        window.addEventListener('scroll', function() {
            const scrollPos = window.pageYOffset;
            const img = document.querySelector('.parallax img');
            if (img) img.style.transform = `translateY(${scrollPos * 0.2}px)`;
        });

        // Search form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.custom-search-bar form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const input = this.querySelector('input[name="q"]');
                    if (!input.value.trim()) {
                        e.preventDefault();
                        alert('Por favor, digite algo para pesquisar');
                        input.focus();
                    }
                });
            }
        });

        // Typed.js initialization
        var typed = new Typed('.typed-effect', {
            strings: ["uma especialidade", "uma clínica", "um exame", "uma vacina"],
            typeSpeed: 60,
            backSpeed: 40,
            backDelay: 1500,
            loop: true
        });
    </script>
@endsection
