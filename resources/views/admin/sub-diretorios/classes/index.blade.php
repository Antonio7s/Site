@extends('layouts.painel-admin')
@section('header_title', 'Classes') <!-- Alterando o h1 -->
@section('content')
        
      <!-- Botão "Adicionar" -->
  <div class="mb-3">
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary mb-3">Adicionar</a>
  </div>

  <hr>

      <div class="row mt-4">
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Classe</th>
                      <th scope="col">Ações</th>
                  </tr>
              </thead>
              <tbody>
                  <!-- Registro 1 -->
                @forelse($classes as $classe)
                  <tr>
                      <td>{{ $classe->id }}</td>
                      <td>{{ $classe->nome }}</td>
                      <td>
                        <a href="{{ route('admin.classes.edit', $classe->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('admin.classes.destroy', $classe->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</button>
                        </form>
                        <a href="{{ route('admin.classes.show', $classe->id)}}" class="btn btn-info btn-sm">Detalhes</a>
                    </td>
                  </tr>
                @empty
                    <tr>
                        <td> Não há registro de classes </td>
                    </tr>
                @endforelse
              </tbody>
          </table>
        <div class="d-flex justify-content-center">
            {{ $classes->links('pagination::bootstrap-5') }}
        </div>
      </div>
  @endsection