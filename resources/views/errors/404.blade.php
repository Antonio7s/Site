<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedExame | Página Não Encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #007aff;
            --secondary-color: #007bff;
            --accent-color: #ff6b6b;
        }
        
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-shadow: 2px 2px 0 rgba(44,165,141,0.1);
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeIn 0.5s ease-in forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        .medical-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .error-message {
            font-size: 1.5rem;
            color: #495057;
            margin-bottom: 2rem;
        }

        .search-box {
            max-width: 500px;
            margin: 0 auto 2rem;
        }

        .decorative-wave {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 20px;
            background: repeating-linear-gradient(
                -45deg,
                var(--primary-color),
                var(--primary-color) 10px,
                transparent 10px,
                transparent 20px
            );
            opacity: 0.3;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #007aff;
            transform: translateY(-2px);
        }

        .animation-delay-1 { animation-delay: 0.2s; }
        .animation-delay-2 { animation-delay: 0.4s; }
        .animation-delay-3 { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="mb-4">
            <div class="error-code">
                <span class="d-inline-block animation-delay-1">4</span>
                <span class="d-inline-block animation-delay-2">0</span>
                <span class="d-inline-block animation-delay-3">4</span>
            </div>
            <i class="bi bi-heart-pulse-fill medical-icon"></i>
        </div>

        <h1 class="mb-3">Página não encontrada</h1>
        <p class="error-message">
            O caminho solicitado não foi localizado em nosso sistema.<br>
            Verifique o endereço ou utilize a busca abaixo para encontrar o que precisa.
        </p>

        <div class="search-box input-group mb-4">
            <input type="text" class="form-control" placeholder="Buscar por especialidades, exames ou profissionais...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <a href="/" class="btn btn-primary btn-lg">
            <i class="bi bi-arrow-left-circle me-2"></i>
            Voltar para a Página Inicial
        </a>

        <div class="decorative-wave"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
