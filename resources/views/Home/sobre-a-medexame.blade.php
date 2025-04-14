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
    <p>A MedExame foi criada para facilitar o acesso à saúde de qualidade. Nossa plataforma conecta você a uma rede de consultórios parceiros, oferecendo consultas, exames, vacinas e procedimentos cirúrgicos com agendamento rápido e preços justos.</p>
    <p>Acreditamos que cuidar da saúde deve ser simples. Por isso, desenvolvemos um sistema intuitivo, seguro e acessível, que permite marcar atendimentos com poucos cliques, no local e horário que melhor se encaixam na sua rotina.</p>
    <p>Todos os nossos parceiros são selecionados com rigor, garantindo atendimento humanizado, estrutura de confiança e profissionais experientes.</p>
    <p>Com a MedExame, você tem mais praticidade, transparência e qualidade no cuidado com a sua saúde — do jeito que você merece.</p>
</div>

@endsection
