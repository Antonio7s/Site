@extends('layouts.appusuarioautentificado')

@push('styles')
  <style>
    .profile-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .profile-card h3 {
      margin-bottom: 15px;
      font-size: 24px;
      color: #333;
    }

    .profile-card p {
      font-size: 16px;
      color: #555;
      margin-bottom: 10px;
    }

    .profile-card .btn {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 10px;
    }

    .profile-card .btn:hover {
      background-color: #0056b3;
    }

    @media (max-width: 768px) {
      .profile-card {
        padding: 15px;
      }

      .profile-card h3 {
        font-size: 20px;
      }

      .profile-card p {
        font-size: 14px;
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
          <a href="#" class="btn">Editar Perfil</a>
        </div>
      </div>
    </div>
  </div>
@endsection
