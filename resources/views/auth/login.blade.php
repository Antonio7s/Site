@extends('layouts.layout-index')

@section('content')
  <style>
    .login-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background-color: #ffffff;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      font-size: 24px;
    }
    .login-container label {
      display: block;
      font-weight: bold;
      color: #555;
      margin-bottom: 5px;
    }
    .login-container input {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 10px;
      width: 100%;
      margin-bottom: 10px;
      font-size: 14px;
      box-sizing: border-box;
    }
    .login-container .error {
      color: #e74c3c;
      font-size: 13px;
      margin-top: -5px;
      margin-bottom: 10px;
    }
    .login-container .actions {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }
    .login-container button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .login-container button:hover {
      background-color: #0056b3;
    }
    .forgot-password {
      text-align: right;
      margin-top: 5px;
    }
    .forgot-password a {
      color: #007bff;
      text-decoration: none;
      font-size: 14px;
    }
    .forgot-password a:hover {
      text-decoration: underline;
    }
  </style>

  <!-- Script do reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}" id="loginForm">
      @csrf

      <!-- Campo Email -->
      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
          <div class="error">{{ $errors->first('email') }}</div>
        @endif
      </div>

      <!-- Campo Senha -->
      <div>
        <label for="password">Senha</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
          <div class="error">{{ $errors->first('password') }}</div>
        @endif
      </div>

      <!-- Link "Esqueci a senha" (abaixo do campo de senha) -->
      <div class="forgot-password">
        <a href="{{ route('password.request') }}">Esqueci a senha</a>
      </div>

      <!-- Widget do reCAPTCHA -->
      <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
      @if ($errors->has('g-recaptcha-response'))
          <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
      @endif

      <!-- Botão "Entrar" -->
      <div class="actions">
        <button type="submit" onclick="checkAdmin(event)">Entrar</button>
      </div>
    </form>
  </div>

  <script>
    function checkAdmin(event) {
        event.preventDefault(); // Impede o envio imediato do formulário

        fetch("{{ url('/admin/dashboard') }}", { // Tenta acessar a rota admin
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = "{{ url('/admin/dashboard') }}"; // Redireciona admins
            } else {
                document.getElementById("loginForm").submit(); // Continua login normal
            }
        })
        .catch(error => {
            console.error("Erro ao verificar admin:", error);
            document.getElementById("loginForm").submit(); // Em caso de erro, continua login normal
        });
    }
  </script>
@endsection
