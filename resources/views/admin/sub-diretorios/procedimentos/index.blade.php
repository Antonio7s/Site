@extends('layouts.painel-admin')
@section('header_title', 'Procedimentos') <!-- Alterando o h1 -->
@section('content')       
        <!-- Botão "Adicionar" -->
        <div class="mb-3">
          <a href="procedimentos2"class="btn btn-primary mb-3">Adicionar</a>
        </div>

        <!-- CORPO -->
            <div class="row mt-4">
                        <!-- Tabela com registros -->
                <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th scope="col">Código</th>
                          <th scope="col">Procedimento</th>
                          <th scope="col">Valor</th>
                          <th scope="col">Ações</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Registro 1 -->
                      <tr>
                          <td>001</td>
                          <td>Exame de Sangue</td>
                          <td>R$ 150,00</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 2 -->
                      <tr>
                          <td>002</td>
                          <td>Raio-X</td>
                          <td>R$ 200,00</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 3 -->
                      <tr>
                          <td>003</td>
                          <td>Ultrassom</td>
                          <td>R$ 250,00</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 4 -->
                      <tr>
                          <td>004</td>
                          <td>Tomografia</td>
                          <td>R$ 350,00</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 5 -->
                      <tr>
                          <td>005</td>
                          <td>Consulta Médica</td>
                          <td>R$ 100,00</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
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