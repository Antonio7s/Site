@extends('layouts.painel-admin')
@section('header_title', 'Procedimentos') <!-- Alterando o h1 -->
@section('content')
        
  <!-- Botão "Adicionar"-->
  <div class="mb-3">
    <a href="{{route('admin.procedimentos.create')}}" class="btn btn-primary mb-3">Adicionar</a>
  </div>

  <hr>

  <!-- EXIBIÇÃO DAS ESPECIALIDADES CADASTRADAS -->
  <div class="row mt-1">
      <!-- Tabela com registros -->
      <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Procedimento</th>
                <th scope="col">Classe associada</th>
                <th scope="col">Valor</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
          @forelse($procedimentos as $procedimento)
            <tr>
                <td> {{ $procedimento->id ?? 'Não informado' }} </td>
                <td> {{ $procedimento->nome ?? 'Não informado' }} </td>
                <td> {{ $procedimento->classe->nome ?? 'Não informado' }} </td>
                <td> {{ $procedimento->valor ?? 'Não informado' }} </td>
                <td>
                    <a href="{{ route('admin.procedimentos.edit', $procedimento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('admin.procedimentos.destroy', $procedimento->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</button>
                    </form>
                    <a href="{{ route('admin.procedimentos.show', $procedimento->id) }}" class="btn btn-info btn-sm">Visualizar</a>
                </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Nenhuma procedimento encontrada.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $procedimentos->links('pagination::bootstrap-5') }}
    </div>
  </div>
@endsection