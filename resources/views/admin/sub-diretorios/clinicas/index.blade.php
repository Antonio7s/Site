@extends('layouts.painel-admin')
@section('header_title', 'Clínicas')
@section('content')

  @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif

  <!-- Botões de Ação -->
  <div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.clinicas.create') }}" class="btn btn-primary">Adicionar Clínica</a>
    <a href="{{ route('admin.clinicas.solicitacoes') }}" class="btn btn-secondary">Ver Solicitações de Cadastro</a>
  </div>

  <!-- CORPO -->
  <div class="row mt-4">
    <h2>Pesquisar</h2>

    <!-- CONTAINER DE PESQUISA -->
    <div class="container">
      <div>
        <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar clínicas cadastradas">
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
    <table class="table table-bordered mt-4" id="clinicasTable">
      <thead class="table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome da Clínica</th>
          <th scope="col">CNPJ</th>
          <th scope="col">Endereço</th>
          <th scope="col">Email</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($clinicas as $clinica)
          <tr>
            <th scope="row">{{ $clinica->id }}</th>
            <td>{{ $clinica->razao_social }}</td>
            <td>{{ $clinica->cnpj_cpf }}</td>
            <td>{{ $clinica->modificar ?? 'Não informado' }}</td>
            <td>{{ $clinica->email ?? 'Não informado' }}</td>
            <td>
              <a href="{{ route('admin.clinicas.edit', $clinica->id) }}" class="btn btn-warning btn-sm">Editar</a>
              <form action="{{ route('admin.clinicas.destroy', $clinica->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Deletar</button>
              </form>
              <a href="{{ route('admin.clinicas.show', $clinica->id) }}" class="btn btn-info btn-sm">Detalhes</a>
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

  <!-- Script para interatividade -->
  <script>
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

    // Função para filtrar as clínicas
    document.getElementById('searchInput').addEventListener('input', function() {
      var filter = this.value.toUpperCase();
      var filterBy = document.getElementById('filterBy').value;
      var table = document.getElementById('clinicasTable');
      var tr = table.getElementsByTagName('tr');

      for (var i = 1; i < tr.length; i++) { // Começa de 1 para pular o cabeçalho
        var tdNome = tr[i].getElementsByTagName('td')[0];
        var tdCnpj = tr[i].getElementsByTagName('td')[1];
        var tdCidade = tr[i].getElementsByTagName('td')[2];

        if (tdNome || tdCnpj || tdCidade) {
          var txtValueNome = tdNome.textContent || tdNome.innerText;
          var txtValueCnpj = tdCnpj.textContent || tdCnpj.innerText;
          var txtValueCidade = tdCidade.textContent || tdCidade.innerText;

          var match = false;

          if (filterBy === 'nome' && txtValueNome.toUpperCase().indexOf(filter) > -1) {
            match = true;
          } else if (filterBy === 'cnpj' && txtValueCnpj.toUpperCase().indexOf(filter) > -1) {
            match = true;
          } else if (filterBy === 'cidade' && txtValueCidade.toUpperCase().indexOf(filter) > -1) {
            match = true;
          } else if (filterBy === 'todos' && (
            txtValueNome.toUpperCase().indexOf(filter) > -1 ||
            txtValueCnpj.toUpperCase().indexOf(filter) > -1 ||
            txtValueCidade.toUpperCase().indexOf(filter) > -1
          )) {
            match = true;
          }

          if (match) {
            tr[i].style.display = '';
          } else {
            tr[i].style.display = 'none';
          }
        }
      }
    });
  </script>
@endsection