@extends('layouts.app')

@section('content')

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
        /* Estilos personalizados */
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
        h2.section-title {
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>

    <!-- Banner -->
    <div class="banner">
        <p>Espaço para o banner</p>
    </div>

    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Profissionais -->
        <div id="main-logo" class="text-start mb-4">
            <h2 class="section-title">Conheça nossos profissionais</h2>
        </div>
        <div class="scroll-bar">
            @php
                $profissionais = [
                    ['nome' => 'Daniele', 'idade' => 27, 'crm' => '25558', 'especialidade' => 'Odontologia', 'imagem' => 'img/img1.jpg'],
                    ['nome' => 'Carlos', 'idade' => 35, 'crm' => '12345', 'especialidade' => 'Cardiologia', 'imagem' => 'img/img2.jpg'],
                    ['nome' => 'Ana', 'idade' => 30, 'crm' => '67890', 'especialidade' => 'Dermatologia', 'imagem' => 'img/img3.jpg'],
                    ['nome' => 'João', 'idade' => 40, 'crm' => '11223', 'especialidade' => 'Ortopedia', 'imagem' => 'img/img4.jpg'],
                    ['nome' => 'Maria', 'idade' => 28, 'crm' => '44556', 'especialidade' => 'Pediatria', 'imagem' => 'img/img5.jpg'],
                    ['nome' => 'Pedro', 'idade' => 33, 'crm' => '77889', 'especialidade' => 'Ginecologia', 'imagem' => 'img/img6.jpg'],
                    ['nome' => 'Luiza', 'idade' => 29, 'crm' => '99001', 'especialidade' => 'Psiquiatria', 'imagem' => 'img/img7.jpg'],
                    ['nome' => 'Rafael', 'idade' => 36, 'crm' => '22334', 'especialidade' => 'Neurologia', 'imagem' => 'img/img8.jpg'],
                    ['nome' => 'Fernanda', 'idade' => 31, 'crm' => '55667', 'especialidade' => 'Endocrinologia', 'imagem' => 'img/img9.jpg'],
                    ['nome' => 'Lucas', 'idade' => 34, 'crm' => '88990', 'especialidade' => 'Oftalmologia', 'imagem' => 'img/img10.jpg']
                ];
            @endphp

            @foreach($profissionais as $profissional)
                <div class="card">
                    <img src="{{ asset($profissional['imagem']) }}" alt="{{ $profissional['nome'] }}">
                    <p>{{ $profissional['nome'] }}, {{ $profissional['idade'] }} anos</p>
                    <p>CRM {{ $profissional['crm'] }}</p>
                    <p><strong>{{ $profissional['especialidade'] }}</strong></p>
                </div>
            @endforeach
        </div>

        <!-- Localização e Sobre a Clínica -->
        <div class="location-and-about">
            <div class="location">
                <h3>Localização</h3>
                @php
                    $localizacao = ['rua' => 'Av. Principal, 123', 'bairro' => 'Centro', 'cidade' => 'São Paulo'];
                @endphp
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

</body>
</html>

@endsection
