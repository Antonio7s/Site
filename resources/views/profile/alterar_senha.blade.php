@extends('layouts.appusuarioautentificado')

@push('styles')
  <style>
    .form-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 25px;
      background-color: #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .form-card h3 {
      margin-bottom: 20px;
      font-size: 28px;
      color: #333;
      font-weight: 600;
    }

    .form-card label {
      font-size: 18px;
      color: #555;
    }

    .form-card input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }

    .form-card .btn-primary {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 12px 25px;
      border-radius: 5px;
      margin-top: 15px;
      width: 100%;
    }

    .form-card .btn-primary:hover {
      background-color: #0056b3;
    }

    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
      font-size: 16px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
@endpush

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="form-card">
          
          <!-- Exibindo mensagens de sucesso ou erro -->
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @elseif (session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
          @endif

          <h3>Alterar Senha</h3>
          
          <form action="{{ route('user.atualizar.senha') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="senha_atual">Senha Atual</label>
              <input type="password" id="senha_atual" name="senha_atual" required>
            </div>
            <div class="form-group">
              <label for="nova_senha">Nova Senha</label>
              <input type="password" id="nova_senha" name="nova_senha" required>
            </div>
            <div class="form-group">
              <label for="confirmar_senha">Confirmar Nova Senha</label>
              <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
