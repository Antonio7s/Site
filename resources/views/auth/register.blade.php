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

  <div class="registration-container">
    <h2>Cadastro</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Campo Nome -->
      <div>
        <label for="name">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @if ($errors->has('name'))
          <div class="error">{{ $errors->first('name') }}</div>
        @endif
      </div>

      <!-- Campo Email -->
      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @if ($errors->has('email'))
          <div class="error">{{ $errors->first('email') }}</div>
        @endif
      </div>

      <!-- Campo Senha -->
      <div>
        <label for="password">Senha</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @if ($errors->has('password'))
          <div class="error">{{ $errors->first('password') }}</div>
        @endif
      </div>

      <!-- Campo Confirmar Senha -->
      <div>
        <label for="password_confirmation">Confirmar Senha</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
        @if ($errors->has('password_confirmation'))
          <div class="error">{{ $errors->first('password_confirmation') }}</div>
        @endif
      </div>

      <div class="actions">
        <a href="{{ route('login') }}">Já registrado? Entrar</a>
        <button type="submit">Cadastrar</button>
      </div>
    </form>
  </div>
@endsection
