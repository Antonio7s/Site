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
    .social-login {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 20px;
    }
    .social-login button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .social-login button.google {
      background-color: #db4437;
      color: #fff;
    }
    .social-login button.facebook {
      background-color: #1877f2;
      color: #fff;
    }
    .social-login button:hover {
      opacity: 0.9;
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

      <!-- Botões de Login Social (um encima do outro) -->
      <div class="social-login">
        <button type="button" class="google">Conectar com Google</button>
        <button type="button" class="facebook">Conectar com Facebook</button>
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


<!-- @extends('layouts.layout-index')


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


 
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


  <div class="registration-container">
    <h2>Cadastro</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf


      
      <div>
        <label for="name">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @if ($errors->has('name'))
          <div class="error">{{ $errors->first('name') }}</div>
        @endif
      </div>


      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @if ($errors->has('email'))
          <div class="error">{{ $errors->first('email') }}</div>
        @endif
      </div>


      <div>
        <label for="password">Senha</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @if ($errors->has('password'))
          <div class="error">{{ $errors->first('password') }}</div>
        @endif
      </div>


     
      <div>
        <label for="password_confirmation">Confirmar Senha</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
        @if ($errors->has('password_confirmation'))
          <div class="error">{{ $errors->first('password_confirmation') }}</div>
        @endif
      </div>


     
      <div class="g-recaptcha" data-sitekey="poem"></div>
      @if ($errors->has('g-recaptcha-response'))
          <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
      @endif


      <div class="actions">
        <a href="{{ route('login') }}">Já registrado? Entrar</a>
        <button type="submit">Cadastrar</button>
      </div>
    </form>
  </div>
@endsection -->




