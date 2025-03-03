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
      margin-bottom: 20px;
    }
  </style>
@endpush

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="form-card">
          <h3>Alterar Informações Básicas</h3>
          
          @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('user.atualizar.informacoes') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Nome</label>
              <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="form-group">
              <label for="telefone">Telefone</label>
              <input type="text" id="telefone" name="telefone" value="{{ Auth::user()->telefone }}" required>
            </div>
            <div class="form-group">
              <label for="data_nascimento">Data de Nascimento</label>
              <input type="date" id="data_nascimento" name="data_nascimento" value="{{ Auth::user()->data_nascimento }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
