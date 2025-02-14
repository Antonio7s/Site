<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Clínica</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #003366;
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: start;
            padding: 10px;
        }
        .sidebar h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: white;
            font-size: 1rem;
            padding: 10px;
            text-decoration: none;
            width: 100%;
            text-align: left;
        }
        .sidebar .nav-link:hover {
            background-color: #004080;
            border-radius: 5px;
        }
        .header {
            background-color: #003366;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            width: calc(100% - 250px);
            left: 250px;
            top: 0;
            z-index: 1000;
        }
        .header .user-info {
            display: flex;
            align-items: center;
        }
        .header .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .content {
            margin-top: 60px;
            margin-left: 250px;
            padding: 20px;
        }
        /* Responsividade */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .header {
                width: 100%;
                left: 0;
                position: relative;
            }
            .content {
                margin-left: 0;
                margin-top: 20px;
            }
            .sidebar h1 {
                font-size: 1.2rem;
            }
            .sidebar .nav-link {
                font-size: 0.9rem;
            }
            .header .user-info img {
                width: 30px;
                height: 30px;
            }
            .header .user-info .dropdown-toggle {
                font-size: 0.9rem;
            }
            .content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Painel Adm Clínica</h1>
        <nav class="nav flex-column">
            <a href="{{ route('admin-clinica.dashboard.index') }}" class="nav-link"> dahsboard</a>
            <a href="#" class="nav-link">Serviços</a>
            <a href="#" class="nav-link">Sobre a Clínica</a>
            <a href="#" class="nav-link">Localização</a>
            <a href="#" class="nav-link">Profissionais Associados</a>
            <a href="#" class="nav-link">Procedimentos</a>
            <a href="#" class="nav-link">Lista de Profissionais</a>
            <a href="#" class="nav-link">Agendamento</a>
        </nav>
    </div>

    <!-- Header -->
    <div class="header">
        <span>Bem-vindo ao Painel</span>
        <div class="user-info">
            <img src="{{ asset('images/icone-usuario.png') }}" alt="Foto da Clínica" width="40">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ Auth::guard('clinic')->user()->nome_fantasia }}
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit2') }}">Perfil</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout2') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Sair</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <main>
            <div class="row mt-4">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
