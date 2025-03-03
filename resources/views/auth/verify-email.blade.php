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

            <!-- Status de envio do link de verificação -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-center text-sm text-green-600">
                    {{ __('Um novo link de verificação foi enviado para o e-mail que você cadastrou.') }}
                </div>
            @endif

            <div class="flex flex-col space-y-1"> 
                <!-- Formulário para reenviar e-mail de verificação -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-verification">
                        {{ __('Reenviar E-mail de Verificação') }}
                    </button>
                </form>
                <!-- Formulário para sair -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-verification">
                        {{ __('Sair') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

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
