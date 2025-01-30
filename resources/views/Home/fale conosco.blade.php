@extends('layouts.app')

@section('title', 'Fale Conosco')

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            box-sizing: border-box;
        }

        h2 {
            font-size: 1.8em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 1em;
            color: #555;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            font-size: 1em;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 1em;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 20px;
            font-size: 1em;
            text-align: center;
            color: #777;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h2 {
                font-size: 1.6em;
            }

            p {
                font-size: 0.95em;
            }

            input[type="submit"] {
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.4em;
            }

            input[type="text"], input[type="email"], textarea {
                font-size: 0.9em;
            }

            input[type="submit"] {
                font-size: 0.95em;
            }

            .footer {
                font-size: 0.9em;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h2>Fale Conosco</h2>

        <p>Se você tiver alguma dúvida ou sugestão, entre em contato conosco preenchendo o formulário abaixo. Responderemos o mais breve possível.</p>

        <form action="{{ route('contato.enviar') }}" method="POST">
            @csrf

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="assunto">Assunto:</label>
            <input type="text" id="assunto" name="assunto" required>

            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="4" required></textarea>

            <input type="submit" value="Enviar">
        </form>

        <div class="footer">
            Ou entre em contato conosco diretamente pelo e-mail 
            <a href="mailto:contato@medexame.com">contato@medexame.com</a>.
        </div>
    </div>
@endsection
