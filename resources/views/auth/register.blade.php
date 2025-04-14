@extends('layouts.layout-index') 

@section('content')
  <style>
    .registration-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background-color: #ffffff;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .registration-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      font-size: 24px;
    }
    .registration-container label {
      display: block;
      font-weight: bold;
      color: #555;
      margin-bottom: 5px;
    }
    .registration-container input {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 10px;
      width: 100%;
      margin-bottom: 10px;
      font-size: 14px;
      box-sizing: border-box;
    }
    .registration-container .error {
      color: #e74c3c;
      font-size: 13px;
      margin-top: -5px;
      margin-bottom: 10px;
    }
    .registration-container .actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }
    .registration-container a {
      color: #007bff;
      text-decoration: none;
      font-size: 14px;
    }
    .registration-container a:hover {
      text-decoration: underline;
    }
    .registration-container button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .registration-container button:hover {
      background-color: #0056b3;
    }
  </style>

  <!-- Script do reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <div class="registration-container">
    <h2>Cadastro</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Nome -->
      <div>
        <label for="name">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @if ($errors->has('name'))
          <div class="error">{{ $errors->first('name') }}</div>
        @endif
      </div>

      <!-- Email -->
      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @if ($errors->has('email'))
          <div class="error">{{ $errors->first('email') }}</div>
        @endif
      </div>

      <!-- CPF -->
      <div>
        <label for="cpf">CPF</label>
        <input id="cpf" type="text" name="cpf" value="{{ old('cpf') }}" required maxlength="14" pattern="\d{3}.\d{3}.\d{3}-\d{2}" placeholder="000.000.000-00" autocomplete="off" oninput="formatCPF(this)">
        @if ($errors->has('cpf'))
          <div class="error">{{ $errors->first('cpf') }}</div>
        @endif
      </div>

      <!-- Telefone -->
      <div>
        <label for="telefone">Telefone</label>
        <input id="telefone" type="text" name="telefone" value="{{ old('telefone') }}" required maxlength="15" placeholder="(00) 00000-0000" oninput="formatTelefone(this)" autocomplete="tel">
        @if ($errors->has('telefone'))
          <div class="error">{{ $errors->first('telefone') }}</div>
        @endif
      </div>

      <!-- Senha -->
      <div>
        <label for="password">Senha</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @if ($errors->has('password'))
          <div class="error">{{ $errors->first('password') }}</div>
        @endif
      </div>

      <!-- Confirmar Senha -->
      <div>
        <label for="password_confirmation">Confirmar Senha</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
        @if ($errors->has('password_confirmation'))
          <div class="error">{{ $errors->first('password_confirmation') }}</div>
        @endif
      </div>

      <!-- Widget do reCAPTCHA -->
      <div class="g-recaptcha mt-3" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
      @if ($errors->has('g-recaptcha-response'))
          <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
      @endif

      <div class="actions">
        <a href="{{ route('login') }}">Já registrado? Entrar</a>
        <button type="submit">Cadastrar</button>
      </div>
    </form>
  </div>

  <script>
    // Função para formatar CPF
    function formatCPF(input) {
      let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
      if (value.length <= 3) {
        input.value = value;
      } else if (value.length <= 6) {
        input.value = value.replace(/(\d{3})(\d{1,})/, '$1.$2');
      } else if (value.length <= 9) {
        input.value = value.replace(/(\d{3})(\d{3})(\d{1,})/, '$1.$2.$3');
      } else {
        input.value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,})/, '$1.$2.$3-$4');
      }
    }

    // Função para formatar Telefone
    function formatTelefone(input) {
      let value = input.value.replace(/\D/g, '');
      if (value.length <= 10) {
        input.value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3').trim();
      } else {
        input.value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3').trim();
      }
    }

    // Validação do reCAPTCHA antes de enviar o formulário
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      form.addEventListener('submit', function(event) {
        if (grecaptcha.getResponse() === '') {
          event.preventDefault();
          alert('Por favor, marque o reCAPTCHA antes de enviar o formulário.');
        }
      });
    });
  </script>
@endsection
