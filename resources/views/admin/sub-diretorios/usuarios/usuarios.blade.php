@extends('layouts.painel-admin')
@section('header_title', 'Usuários')
@section('content')
<div class="row mt-4">
    <!-- Filtro e Barra de Pesquisa -->
    <div class="col-md-12 mb-3">
        <div class="row">
            <!-- Coluna do filtro com label e select -->
            <div class="col-md-3">
                <label for="filtro">Filtrar</label>
                <select id="filtro" class="form-control">
                    <option value="todos">Todos</option>
                    <option value="nome">Nome</option>
                    <option value="email">Email</option>
                </select>
            </div>
            <!-- Coluna da pesquisa, alinhada na base para ficar na mesma linha -->
            <div class="col-md-9 d-flex align-items-end">
                <input type="text" id="barra-pesquisa" class="form-control" placeholder="Pesquisar usuários cadastrados">
            </div>
        </div>
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
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Deletar</button>
                            <button class="btn btn-info btn-sm">Detalhes</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Script para interatividade -->
<script>
    // Função para filtrar a tabela
    function filtrarTabela() {
        const filtro = document.getElementById('filtro').value;
        const termo = document.getElementById('barra-pesquisa').value.toLowerCase();
        const linhas = document.querySelectorAll('#tabela-usuarios tr');

        linhas.forEach(linha => {
            const nome = linha.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const email = linha.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';
            let corresponde = false;

            if (filtro === 'todos') {
                corresponde = nome.includes(termo) || email.includes(termo);
            } else if (filtro === 'nome') {
                corresponde = nome.includes(termo);
            } else if (filtro === 'email') {
                corresponde = email.includes(termo);
            }

            linha.style.display = corresponde ? '' : 'none';
        });
    }

    // Adiciona eventos para o filtro e a barra de pesquisa
    document.getElementById('filtro').addEventListener('change', filtrarTabela);
    document.getElementById('barra-pesquisa').addEventListener('input', filtrarTabela);

    // Função para fechar dropdowns ao clicar fora
    function toggleDropdown(id) {
        const dropdown = document.getElementById(`${id}-dropdown`);
        dropdown.classList.toggle('show');
    }

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
