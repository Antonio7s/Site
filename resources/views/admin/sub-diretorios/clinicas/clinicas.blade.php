@extends('layouts.painel-admin')
@section('header_title', 'Clínicas')
@section('content')
  <!-- Botões de Ação -->
  <div class="d-flex justify-content-between mb-3">
    <a href="clinicas2" class="btn btn-primary">Adicionar Clínica</a>
    <a href="clinicas3" class="btn btn-secondary">Ver Solicitações de Cadastro</a>
  </div>

  <!-- CORPO -->
  <div class="row mt-4">
    <h2>Pesquisar</h2>

    <!-- CONTAINER DE PESQUISA -->
    <div class="container">
      <div>
        <input type="text" class="form-control" placeholder="Pesquisar clínicas cadastradas">
      </div>

      <!-- Filtros -->
      <div class="filter-container">
        <div class="row">
          <!-- Buscar por -->
          <div class="col-md-6">
            <label for="filterBy">Filtros</label>
            <select class="form-control" id="filterBy">
              <option value="todos">Todos</option>
              <option value="nome">Nome</option>
              <option value="cnpj">CNPJ</option>
              <option value="cidade">Cidade</option>
            </select>
          </div>

          <!-- Taxa de Lucro -->
          <div class="col-md-6">
            <label for="profitRate">Taxa de Lucro:</label>
            <select class="form-control" id="profitRate">
              <option value="todos">Todos</option>
              <option value="valor_exato">Valor exato</option>
              <option value="intervalo">Intervalo</option>
            </select>
          </div>
        </div>

        <!-- Intervalo de Taxa de Lucro -->
        <div class="row mt-3" id="profitRateRange" style="display:none;">
          <div class="col-md-12 d-flex ml-auto justify-content-end gap-3">
            <div class="w-15">
              <label for="minRate">Mínimo:</label>
              <input type="number" class="form-control form-control-sm" id="minRate" placeholder="Ex: 1">
            </div>
            <div class="w-15">
              <label for="maxRate">Máximo:</label>
              <input type="number" class="form-control form-control-sm" id="maxRate" placeholder="Ex: 2">
            </div>
          </div>
        </div>
      </div>

      <!-- Botão de Filtrar -->
      <div class="form-group mt-4">
        <button class="btn btn-success">Filtrar</button>
      </div>
    </div>

         <!-- Lista de Clínicas Cadastradas -->
         <table class="table table-bordered mt-4">
        <thead class="table-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome da Clínica</th>
            <th scope="col">CNPJ</th>
            <th scope="col">Endereço</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($clinicas as $clinica)
            <tr>
              <th scope="row">{{ $clinica->id }}</th>
              <td>{{ $clinica->nome }}</td>
              <td>{{ $clinica->cnpj }}</td>
              <td>{{ $clinica->endereco }}</td>
              <td>
                <a href="{{ route('clinicas.edit', $clinica->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('clinicas.destroy', $clinica->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm">Deletar</button>
                </form>
                <a href="{{ route('clinicas.show', $clinica->id) }}" class="btn btn-info btn-sm">Detalhes</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Nenhuma clínica encontrada.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <!-- Links de Paginação -->
      <div class="d-flex justify-content-center">
        {{ $clinicas->links() }}
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

    // Exibir intervalo de taxa de lucro
    document.getElementById('profitRate').addEventListener('change', function() {
      var profitRate = this.value;
      var profitRateRange = document.getElementById('profitRateRange');
      if (profitRate === 'intervalo') {
        profitRateRange.style.display = 'flex';
      } else {
        profitRateRange.style.display = 'none';
      }
    });
  </script>
@endsection