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
    <table class="table table-bordered">
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
        <!-- Exemplo 1 -->
        <tr>
          <th scope="row">1</th>
          <td>Clínica Saúde Total</td>
          <td>12.345.678/0001-99</td>
          <td>Rua Principal, 123, Centro</td>
          <td>
            <button class="btn btn-warning btn-sm">Editar</button>
            <button class="btn btn-danger btn-sm">Deletar</button>
            <a class="btn btn-info btn-sm" href="clinicas5">Detalhes</a>
          </td>
        </tr>
        <!-- Exemplo 2 -->
        <tr>
          <th scope="row">2</th>
          <td>Clínica Vida e Saúde</td>
          <td>98.765.432/0001-11</td>
          <td>Avenida Secundária, 456, Bairro Novo</td>
          <td>
            <button class="btn btn-warning btn-sm">Editar</button>
            <button class="btn btn-danger btn-sm">Deletar</button>
            <button class="btn btn-info btn-sm">Detalhes</button>
          </td>
        </tr>
        <!-- Exemplo 3 -->
        <tr>
          <th scope="row">3</th>
          <td>Clínica Bem Estar</td>
          <td>23.456.789/0001-22</td>
          <td>Praça Central, 789, Vila Antiga</td>
          <td>
            <button class="btn btn-warning btn-sm">Editar</button>
            <button class="btn btn-danger btn-sm">Deletar</button>
            <button class="btn btn-info btn-sm">Detalhes</button>
          </td>
        </tr>
      </tbody>
    </table>
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