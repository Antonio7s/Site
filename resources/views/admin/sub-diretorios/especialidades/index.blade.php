@extends('layouts.painel-admin')
@section('header_title', 'Especialidades') <!-- Alterando o h1 -->
@section('content')
        
  <!-- Botão "Adicionar" ESPECIALIDADE-->
  <div class="mb-3">
    <a href="{{route('admin.especialidades.create')}}" class="btn btn-primary mb-3">Adicionar</a>
  </div>

  <hr>

  <!-- EXIBIÇÃO DAS ESPECIALIDADES CADASTRADAS -->
  <div class="row mt-1">
      <!-- Tabela com registros -->
      <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Especialidade</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
          @forelse($especialidades as $especialidade)
            <tr>
                <td> {{ $especialidade->id ?? 'Não informado' }} </td>
                <td> {{ $especialidade->nome ?? 'Não informado' }} </td>
                <td>
                    <a href="{{ route('admin.especialidades.edit', $especialidade->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('admin.especialidades.destroy', $especialidade->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</button>
                    </form>
                    <a href="{{ route('admin.especialidades.show', $especialidade->id) }}" class="btn btn-info btn-sm">Visualizar</a>
                </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Nenhuma especialidade encontrada.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
  </div>
@endsection