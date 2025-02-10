@extends('layouts.layout-index')  

@section('content')

    <div class="min-h-screen flex items-center justify-center bg-gray-200 px-4">
        <div class="bg-white shadow-md rounded-lg p-6 max-w-xs w-full">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-4">
                Verificação de E-mail
            </h2>
            <p class="text-sm text-gray-700 text-center mb-6">
                {{ __('Obrigado por se cadastrar! Antes de começarmos, por favor, verifique seu e-mail clicando no link que enviamos. Caso não tenha recebido o e-mail, ficaremos felizes em enviar outro.') }}
            </p>

            <div id="status-message" class="mb-4 text-center text-sm text-green-600 hidden">
                {{ __('Um novo link de verificação foi enviado para o e-mail que você cadastrou.') }}
            </div>

            <div class="flex flex-col space-y-1"> 
                <form id="resend-email-form" method="POST" action="{{ route('verification.send2') }}">
                    @csrf
                    <button type="submit" class="btn-verification" id="resend-email-button">
                        {{ __('Reenviar E-mail de Verificação') }}
                    </button>
                </form>
                <form method="POST" action="{{ route('logout2') }}">
                    @csrf
                    <button type="submit" class="btn-verification">
                        {{ __('Sair') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("resend-email-form").addEventListener("submit", function(event) {
            event.preventDefault();
            
            fetch(this.action, {
                method: "POST",
                body: new FormData(this),
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "verification-link-sent") {
                    document.getElementById("status-message").classList.remove("hidden");
                }
            })
            .catch(error => console.error("Erro ao reenviar e-mail:", error));
        });
    </script>

    <style>
        .hidden { display: none; }
        .min-h-screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f5f9;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .bg-white {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            max-width: 20rem;
            width: 100%;
        }
        .btn-verification {
            width: 100%;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            font-weight: 500;
            border-radius: 0.375rem;
            border: 1px solid #007bff;
            font-size: 1rem;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            margin-bottom: 5px;
        }
        .btn-verification:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .btn-verification:focus {
            outline: none;
            ring: 2px solid #007bff;
        }
        .btn-verification:active {
            transform: scale(0.98);
        }
    </style>

@endsection
