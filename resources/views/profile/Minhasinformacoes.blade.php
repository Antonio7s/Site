@extends('layouts.appusuarioautentificado')

@push('styles')
  <style>
    .profile-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 25px;
      background-color: #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .profile-card h3 {
      margin-bottom: 20px;
      font-size: 28px;
      color: #333;
      font-weight: 600;
    }

    .profile-card p {
      font-size: 18px;
      color: #555;
      margin-bottom: 15px;
    }

    .profile-card .btn {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 12px 25px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
      transition: background-color 0.3s ease;
    }

    .profile-card .btn:hover {
      background-color: #0056b3;
    }

    .profile-card .btn-secondary {
      background-color: #28a745;
    }

    .profile-card .btn-secondary:hover {
      background-color: #218838;
    }

    .profile-card .btn-warning {
      background-color: #ffc107;
    }

    .profile-card .btn-warning:hover {
      background-color: #e0a800;
    }

    .profile-card .btn-danger {
      background-color: #dc3545;
    }

    .profile-card .btn-danger:hover {
      background-color: #c82333;
    }

    .row {
      margin-top: 50px;
    }

    @media (max-width: 768px) {
      .profile-card {
        padding: 20px;
      }

      .profile-card h3 {
        font-size: 22px;
      }

      .profile-card p {
        font-size: 16px;
      }

      .profile-card .btn {
        padding: 10px 20px;
      }
    }
  </style>
@endpush

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="profile-card">
          <h3>Minhas Informações</h3>
          <p><strong>Nome:</strong> {{ Auth::user()->name }}</p>
          <p><strong>E-mail:</strong> {{ Auth::user()->email }}</p>
          <p><strong>Data de Nascimento:</strong> {{ Auth::user()->data_nascimento ?? 'Não informado' }}</p>
          <p><strong>Telefone:</strong> {{ Auth::user()->telefone ?? 'Não informado' }}</p>
          
          <a href="{{ route('user.perfil.editar') }}" class="btn">Alterar Informações Básicas</a>
          <!-- <a href="#" class="btn btn-warning">Alterar E-mail</a> -->
          <a href="{{ route('user.mostrar.formulario.senha') }}" class="btn btn-danger">Alterar Senha</a>
        </div>
      </div>
    </div>
  </div>
@endsection
