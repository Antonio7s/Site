<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medexame</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .header, footer {
            background-color: #007bff;
            color: white;
        }
        .header {
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header .menu {
            flex: 1;
            text-align: center;
        }
        .header .menu a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin: 0 1rem;
            font-size: 1rem;
        }
        .banner {
            margin: 1rem auto;
            height: 200px;
            width: 80%;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            color: #666;
            border: 1px dashed #ccc;
        }
        .scroll-bar {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding: 1rem 0;
            scroll-behavior: smooth;
        }
        .scroll-bar::-webkit-scrollbar {
            display: none;
        }
        .scroll-bar .card {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 180px;
            height: 250px;
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 1rem;
        }
        .scroll-bar .card img {
            height: 100px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }
        .location-and-about {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }
        .location {
            flex: 2;
        }
        .about {
            flex: 1;
        }
        footer {
            padding: 2rem 0;
            text-align: center;
        }
        .social-icons a {
            color: white;
            font-size: 1.5rem;
        }
        h2.section-title {
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 40px;">
        <nav class="menu">
            <a href="#">HOME</a>
            <span>|</span>
            <a href="#">SERVIÇOS</a>
            <span>|</span>
            <a href="#">EXAMES</a>
            <span>|</span>
            <a href="#">CONSULTAS</a>
        </nav>
        <div class="d-flex align-items-center">
            <input type="text" class="form-control me-3" placeholder="Pesquisar">
            <div class="d-flex align-items-center">
                <img src="{{ asset('user.png') }}" alt="User" style="height: 40px; border-radius: 50%; margin-right: 0.5rem;">
                <span id="user-initials">JD</span>
            </div>
        </div>
    </header>

    <!-- Banner -->
    <div class="banner">
        <p>Espaço para o banner</p>
    </div>

    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Logo and Professionals Section -->
        <div id="main-logo" class="text-start mb-4">
            <h2 class="section-title">Conheça nossos profissionais</h2>
        </div>
        <div class="scroll-bar">
            @foreach($profissionais as $profissional)
                <div class="card">
                    <img src="{{ asset($profissional['imagem']) }}" alt="{{ $profissional['nome'] }}">
                    <p>{{ $profissional['nome'] }}, {{ $profissional['idade'] }} anos</p>
                    <p>CRM {{ $profissional['crm'] }}</p>
                    <p><strong>{{ $profissional['especialidade'] }}</strong></p>
                </div>
            @endforeach
        </div>

        <!-- Nossos Serviços -->
        <div class="services-section">
            <h2 class="section-title">Nossos Serviços</h2>
            <div class="service-box">
                <h3>Especialidades</h3>
                <ul>
                    @foreach($especialidades as $especialidade)
                        <li>
                            <label>{{ $especialidade['nome'] }} - R$ {{ number_format($especialidade['preco'], 2, ',', '.') }}</label>
                            <input type="checkbox">
                        </li>
                    @endforeach
                </ul>
                <div class="total">Total: R$ 0,00</div>
            </div>
        </div>

        <!-- Location and About Section -->
        <div class="location-and-about">
            <div class="location">
                <h3>Localização</h3>
                <p>Rua: {{ $localizacao['rua'] }}</p>
                <p>Bairro: {{ $localizacao['bairro'] }}</p>
                <p>Cidade: {{ $localizacao['cidade'] }}</p>
            </div>
            <div class="about">
                <h3>Sobre a Clínica</h3>
                <p>Nossa clínica oferece uma ampla gama de serviços médicos com os melhores profissionais.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
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
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Rolagem automática dos médicos
        let scrollBar = document.querySelector('.scroll-bar');
        let scrollWidth = scrollBar.scrollWidth;
        let scrollPosition = 0;

        setInterval(() => {
            scrollPosition += 180;
            if (scrollPosition >= scrollWidth) {
                scrollPosition = 0;
            }
            scrollBar.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }, 10000);

        // Cálculo do total para especialidades
        function calculateTotal(checkboxClass, totalClass) {
            let checkboxes = document.querySelectorAll(checkboxClass);
            let totalElement = document.querySelector(totalClass);
            let total = 0;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    let price = parseFloat(checkbox.parentElement.textContent.split('R$ ')[1].replace(',', '.'));
                    if (checkbox.checked) {
                        total += price;
                    } else {
                        total -= price;
                    }
                    totalElement.textContent = `Total: R$ ${total.toFixed(2).replace('.', ',')}`;
                });
            });
        }

        calculateTotal('.service-box:nth-child(1) input[type="checkbox"]', '.service-box:nth-child(1) .total');
    </script>
</body>
</html>