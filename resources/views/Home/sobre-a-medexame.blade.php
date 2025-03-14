@extends('layouts.layout-index')

@section('content')
@php
    $titulo = "Sobre a MedExame";
    $empresa = "MedExame";
    $email_contato = "contato@medexame.com";
@endphp

<style>
    #body1 {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        margin: 0;
        padding: 0;
    }
    #container1 {
        width: 90%;
        max-width: 800px;
        margin: 50px auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        color: #4cb3f7;
        font-size: 2em;
        margin-bottom: 20px;
    }
    p {
        font-size: 1.2em;
        line-height: 1.6;
        margin-bottom: 20px;
        text-align: justify;
    }
    .highlight {
        color: #4cb3f7;
        font-weight: bold;
    }
</style>

<div class="container" id="container1">
    <h1>{{ $titulo }}</h1>
    <p>A <span class="highlight">{{ $empresa }}</span> é uma plataforma inovadora que conecta pacientes a diversos consultórios parceiros, oferecendo uma ampla variedade de consultas e exames médicos de forma acessível e prática.</p>
    <p>Nossa missão é proporcionar saúde e bem-estar por meio de um serviço confiável, com preços acessíveis e com a <span class="highlight">comodidade</span> que você merece. Com poucos cliques, você pode agendar consultas e exames com profissionais qualificados e em locais de confiança.</p>
    <p>Trabalhamos com um modelo que valoriza a sua <span class="highlight">praticidade</span>, garantindo que todo o processo seja rápido, intuitivo e seguro. Além disso, nossos parceiros foram cuidadosamente selecionados para oferecer o melhor atendimento.</p>
    <p>Escolha a <span class="highlight">{{ $empresa }}</span> e tenha acesso a cuidados médicos de qualidade, com transparência, eficiência e a melhor experiência para o paciente.</p>
</div>

@endsection