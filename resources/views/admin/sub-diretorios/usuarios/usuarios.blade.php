@extends('layouts.painel-admin')
@section('header_title', 'Usuários') <!-- Alterando o h1 -->
@section('content')
            <div class="row mt-4">

                <div>
                  <input type="text" class="form-control" placeholder="Pesquisar usuários cadastrados">
                </div>

                <!-- Lista de Usuários Cadastradas -->
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
                <tbody>
                  @forelse($usuarios as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id ?? 'Não informado' }}</th>
                        <td>{{ $usuario->name ?? 'Não informado' }}</td>
                        <td>{{ $usuario->cpf ?? 'Não informado' }}</td>
                        <td>{{ $usuario->endereco ?? 'Não informado' }}</td>
                        <td>{{ $usuario->email ?? 'Não informado' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Deletar</button>
                            <button class="btn btn-info btn-sm">Detalhes</button>
                        </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5">Nenhum usuario encontrada.</td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
            </div>


      </div>
    </div>
  </div>

<!-- Script para interatividade -->
  <script>
    function toggleDropdown(id) {
      const dropdown = document.getElementById(`${id}-dropdown`);
      dropdown.classList.toggle('show');
    }

    // Fechar dropdowns ao clicar fora
    window.onclick = function(event) {
      if (!event.target.matches('.notifications, .email, .profile')) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
          if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
          }
        });
      }
    };
  </script>
@endsection