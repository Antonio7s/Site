@extends('layouts.app')

@section('content')
<div class="container" id="container1">
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
  <style>

    /* Container principal */
    /* Container principal */
  #container1 {
    background-color: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 700px;
    text-align: center;
    margin: 20px auto; /* Ajustado para centralizar */
    display: block;
}

    /* Título */
    h2 {
        font-size: 1.8em;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    /* Subtítulo da tabela */
    p {
        font-size: 0.9em;
        color:rgb(247, 253, 253);
        margin-bottom: 20px;
    }

    /* Labels */
    label {
        font-size: 0.9em;
        color: #34495e;
        margin-bottom: 5px;
        display: block;
        font-weight: 500;
        text-align: left;
    }

    /* Inputs e Textarea */
    input, textarea {
        width: 100%;
        padding: 10px;
        margin: 6px 0 15px;
        border: 1px solid #bdc3c7;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 0.9em;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical; /* Permite redimensionar verticalmente */
    }

    /* Botão */
    button {
        background-color: #3498db;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1em;
        width: 100%;
        transition: background-color 0.3s;
        font-weight: 600;
    }

    button:hover {
        background-color: #2980b9;
    }

</style>
@endsection
