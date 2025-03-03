@extends('layouts.painel-admin')
@section('header_title', 'Usuários')
@section('content')
<div class="row mt-4">
    <!-- Filtro e Barra de Pesquisa -->
    <div class="col-md-12 mb-3">
        <form method="GET" action="{{ route('admin.usuarios.index') }}">
            <div class="row">
                <!-- Coluna do filtro com label e select -->
                <div class="col-md-3">
                    <label for="filtro">Filtrar</label>
                    <select id="filtro" name="filtro" class="form-control">
                        <option value="todos" {{ request('filtro') == 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="nome" {{ request('filtro') == 'nome' ? 'selected' : '' }}>Nome</option>
                        <option value="email" {{ request('filtro') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                </div>
                <!-- Coluna da pesquisa, alinhada na base para ficar na mesma linha -->
                <div class="col-md-7 d-flex align-items-end">
                    <input type="text" id="barra-pesquisa" name="search" class="form-control" placeholder="Pesquisar usuários cadastrados" value="{{ request('search') }}">
                </div>
                <!-- Botão de pesquisa -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Lista de Usuários Cadastrados -->
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome do Usuário</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-usuarios">
                @forelse($usuarios as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id ?? 'Não informado' }}</th>
                        <td>{{ $usuario->name ?? 'Não informado' }}</td>
                        <td>{{ $usuario->cpf ?? 'Não informado' }}</td>
                        <td>{{ $usuario->endereco ?? 'Não informado' }}</td>
                        <td>{{ $usuario->email ?? 'Não informado' }}</td>
                        <td>
                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                            </form>
                            <a href="{{ route('admin.usuarios.show', $usuario->id) }}" class="btn btn-info btn-sm">Detalhes</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Links de paginação -->
        <div class="d-flex justify-content-center">
            {{ $usuarios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection