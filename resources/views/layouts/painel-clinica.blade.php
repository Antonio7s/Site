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
        .tab-content .form-label {
            font-weight: bold;
        }

        /* Ajustes nas abas */
        .nav-link.active {
            background-color: #004080;
        }

        /* Ajustes para o formulário de Profissionais Associados */
        .form-select {
            width: 100%;
            border-radius: 5px;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .photo-input {
            display: block;
            margin-top: 10px;
        }

        /* Estilo para a aba de especialidades */
        .specialty-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1050;
        }
        .specialty-modal.show {
            display: block;
        }
        .specialty-modal .modal-content {
            max-height: 300px;
            overflow-y: auto;
        }
        .specialty-modal .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .specialty-modal .modal-footer button {
            margin-left: 10px;
        }

        /* Estilo para a tabela de procedimentos */
        #procedimentosTable table {
            width: 100%;
            border-collapse: collapse;
        }

        #procedimentosTable th, #procedimentosTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #procedimentosTable th {
            background-color: #f2f2f2;
            text-align: left;
        }

        /* Estilo para os cards de horário */
        .horario-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
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
            .tab-content .form-label {
                font-size: 0.9rem;
            }
            .form-control, .form-select {
                font-size: 0.9rem;
            }
            .btn {
                font-size: 0.9rem;
            }
            .specialty-modal {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Painel Adm Clínica</h1>
        <div class="nav flex-column" role="tablist">
            <a href="#servicos" class="nav-link" data-bs-toggle="tab" role="tab">Serviços</a>
            <a href="#sobre-clinica" class="nav-link" data-bs-toggle="tab" role="tab">Sobre a Clínica</a>
            <a href="#localizacao" class="nav-link" data-bs-toggle="tab" role="tab">Localização</a>
            <a href="#profissionais-associados" class="nav-link" data-bs-toggle="tab" role="tab">Profissionais Associados</a>
            <a href="#procedimentos" class="nav-link" data-bs-toggle="tab" role="tab">Procedimentos</a>
            <a href="#lista-profissionais" class="nav-link" data-bs-toggle="tab" role="tab">Lista de Profissionais</a>
            <a href="#agendamento" class="nav-link" data-bs-toggle="tab" role="tab">Agendamento</a>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <span>Bem-vindo ao Painel</span>
        <div class="user-info">
            <img src="{{ asset('images/icone-usuario.png') }}" alt="Foto da Clínica" width="40">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <!-- Nome do usuário logado -->
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
        
            <!-- Conteúdo da página -->
            <main>
                <div class="row mt-4">
                    @yield('content') <!-- Aqui é o conteúdo da página -->
                </div>
            </main>
            
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
</body>
</html>