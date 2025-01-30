@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Fale Conosco</h2>
    <p>Tem alguma dúvida ou sugestão? Preencha o formulário abaixo e retornaremos o mais breve possível.</p>
    <form method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
        </div>

        <div class="mb-3">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
        </div>

        <div class="mb-3">
            <label for="assunto">Assunto:</label>
            <input type="text" id="assunto" name="assunto" placeholder="Digite o assunto" required>
        </div>

        <div class="mb-3">
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="4" placeholder="Digite sua mensagem" required></textarea>
        </div>

        <button type="submit">Enviar</button>
    </form>
    <div class="footer">
        Ou entre em contato pelo e-mail <a href="mailto:contato@medexame.com">contato@medexame.com</a>.
    </div>
</div>
@endsection