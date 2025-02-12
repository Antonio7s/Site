@extends('layouts.painel-admin')
@section('header_title', 'Solicitações de cadastro') <!-- Alterando o h1 -->
@section('content')
        <!-- CORPO -->
            <div class="row mt-4">
                
                    <!-- Tabela de Solicitações -->
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome da Clínica</th>
                            <th scope="col">CNPJ</th>
                            <th scope="col">Localização</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemplo 1 -->
                        <tr>
                            <th scope="row">1</th>
                            <td>Clínica Saúde Nova</td>
                            <td>12.345.678/0001-99</td>
                            <td>Rua Central, 45, Centro</td>
                            <td>
                                <a href="clinicas4" class="btn btn-primary btn-sm">Analisar</a>
                            </td>
                        </tr>
                        <!-- Exemplo 2 -->
                        <tr>
                            <th scope="row">2</th>
                            <td>Clínica Bem-Estar</td>
                            <td>23.456.789/0001-88</td>
                            <td>Avenida Principal, 123, Bairro Novo</td>
                            <td>
                                <a href="clinicas4" class="btn btn-primary btn-sm">Analisar</a>
                            </td>
                        </tr>
                        <!-- Exemplo 3 -->
                        <tr>
                            <th scope="row">3</th>
                            <td>Clínica Vida Saudável</td>
                            <td>34.567.890/0001-77</td>
                            <td>Travessa Secundária, 789, Vila Velha</td>
                            <td>
                                <a href="clinicas4" class="btn btn-primary btn-sm">Analisar</a>
                            </td>
                        </tr>
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