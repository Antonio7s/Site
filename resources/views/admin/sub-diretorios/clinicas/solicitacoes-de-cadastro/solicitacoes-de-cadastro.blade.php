@extends('layouts.painel-admin')
@section('header_title', 'Solicitações de cadastro') <!-- Alterando o h1 -->
@section('content')

  @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif

  <!-- CORPO -->
  <div class="row mt-4">
      <!-- Tabela de Solicitações -->
      <table class="table table-bordered">
          <thead class="table-dark">
              <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nome da Clínica</th>
                  <th scope="col">CNPJ</th>
                  <th scope="col">Localização</th>
                  <th scope="col">Ação</th>
              </tr>
          </thead>
          <tbody>
              <!-- Exemplo 1 -->
              @foreach($clinicas as $clinica)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $clinica->razao_social ?? 'Não informado'}}</td>
                    <td>{{ $clinica->cnpj_cpf ?? 'Não informado'}}</td>
                    <td>{{ $clinica->email ?? 'Não informado'}}</td>
                    <td>
                        <a href="{{ route('admin.clinicas.solicitacoes-de-cadastro.analise', $clinica->id) }}" class="btn btn-primary btn-sm">Analisar</a>
                    </td>
                </tr>
                @endforeach
          </tbody>
    </table>
          <!-- Links de paginação -->
    <div class="d-flex justify-content-center">
        {{ $clinicas->links('pagination::bootstrap-5') }}
    </div>



  </div>
@endsection