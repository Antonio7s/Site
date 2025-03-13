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
      <form action="{{ route('admin.clinicas.index') }}" method="GET">
        <div>
          <input type="text" name="search" id="searchInput" class="form-control" placeholder="Pesquisar clínicas cadastradas" value="{{ request('search') }}">
        </div>

        <!-- Filtros -->
        <div class="filter-container">
          <div class="row">
            <!-- Buscar por -->
            <div class="col-md-6">
              <label for="filterBy">Filtros</label>
              <select class="form-control" id="filterBy" name="filterBy">
                <option value="todos" {{ request('filterBy') == 'todos' ? 'selected' : '' }}>Todos</option>
                <option value="nome" {{ request('filterBy') == 'nome' ? 'selected' : '' }}>Nome</option>
                <option value="cnpj" {{ request('filterBy') == 'cnpj' ? 'selected' : '' }}>CNPJ</option>
                <option value="cidade" {{ request('filterBy') == 'cidade' ? 'selected' : '' }}>Cidade</option>
              </select>
            </div>

            <!-- Taxa de Lucro -->
            <div class="col-md-6">
              <label for="profitRate">Taxa de Lucro:</label>
              <select class="form-control" id="profitRate" name="profitRate">
                <option value="todos" {{ request('profitRate') == 'todos' ? 'selected' : '' }}>Todos</option>
                <option value="valor_exato" {{ request('profitRate') == 'valor_exato' ? 'selected' : '' }}>Valor exato</option>
                <option value="intervalo" {{ request('profitRate') == 'intervalo' ? 'selected' : '' }}>Intervalo</option>
              </select>
            </div>
          </div>

          <!-- Valor Exato de Taxa de Lucro -->
          <div class="row mt-3" id="profitRateExact" style="display: {{ request('profitRate') == 'valor_exato' ? 'flex' : 'none' }};">
            <div class="col-md-12 d-flex ml-auto justify-content-end gap-3">
              <div class="w-15">
                <label for="exactRate">Valor Exato:</label>
                <input type="number" class="form-control form-control-sm" id="exactRate" name="exactRate" placeholder="Ex: 5" value="{{ request('exactRate') }}">
              </div>
            </div>
          </div>

          <!-- Intervalo de Taxa de Lucro -->
          <div class="row mt-3" id="profitRateRange" style="display: {{ request('profitRate') == 'intervalo' ? 'flex' : 'none' }};">
            <div class="col-md-12 d-flex ml-auto justify-content-end gap-3">
              <div class="w-15">
                <label for="minRate">Mínimo:</label>
                <input type="number" class="form-control form-control-sm" id="minRate" name="minRate" placeholder="Ex: 1" value="{{ request('minRate') }}">
              </div>
              <div class="w-15">
                <label for="maxRate">Máximo:</label>
                <input type="number" class="form-control form-control-sm" id="maxRate" name="maxRate" placeholder="Ex: 10" value="{{ request('maxRate') }}">
              </div>
            </div>
          </div>
        </div>

        <!-- Botão de Filtrar -->
        <div class="form-group mt-4">
          <button type="submit" class="btn btn-success">Filtrar</button>
          <a href="{{ route('admin.clinicas.index') }}" class="btn btn-secondary">Limpar Filtros</a>
        </div>
      </form>
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
            <td>{{ $clinica->endereco ?? 'Não informado' }}</td>
            <td>{{ $clinica->email ?? 'Não informado' }}</td>
            <td>
              <a href="{{ route('admin.clinicas.edit', $clinica->id) }}" class="btn btn-warning btn-sm">Editar</a>
              <!-- <form action="{{ route('admin.clinicas.destroy', $clinica->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
              </form> -->
              <a href="{{ route('admin.clinicas.show', $clinica->id) }}" class="btn btn-info btn-sm">Detalhes</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">Nenhuma clínica encontrada.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center">
      {{ $clinicas->links('pagination::bootstrap-5') }}
    </div>
  </div>

  <!-- Script para interatividade -->
  <!-- Se for usar somente a pesquisa server-side, é recomendado remover o bloco de filtragem client-side -->
  <script>
    // Exibir intervalo ou valor exato de taxa de lucro
    document.getElementById('profitRate').addEventListener('change', function() {
      var profitRate = this.value;
      var profitRateRange = document.getElementById('profitRateRange');
      var profitRateExact = document.getElementById('profitRateExact');

      if (profitRate === 'intervalo') {
        profitRateRange.style.display = 'flex';
        profitRateExact.style.display = 'none';
      } else if (profitRate === 'valor_exato') {
        profitRateExact.style.display = 'flex';
        profitRateRange.style.display = 'none';
      } else {
        profitRateRange.style.display = 'none';
        profitRateExact.style.display = 'none';
      }
    });
  </script>
@endsection
