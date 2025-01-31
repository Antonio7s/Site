@extends('layouts.painel-admin')
@section('header_title', 'Especialidades') <!-- Alterando o h1 -->
@section('content')
        
        <!-- Botão "Adicionar" -->
        <div class="mb-3">
          <a href="especialidades2" class="btn btn-primary mb-3">Adicionar</a>
        </div>
        <hr>
        <!-- CORPO -->
            <div class="row mt-1">
                <!-- Tabela com registros -->
                <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th scope="col">Código</th>
                          <th scope="col">Especialidade</th>
                          <th scope="col">Ações</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Registro 1 -->
                      <tr>
                          <td>001</td>
                          <td>Cardiologia</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 2 -->
                      <tr>
                          <td>002</td>
                          <td>Neurologia</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 3 -->
                      <tr>
                          <td>003</td>
                          <td>Ortopedia</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 4 -->
                      <tr>
                          <td>004</td>
                          <td>Pediatria</td>
                          <td>
                              <button class="btn btn-warning btn-sm">Editar</button>
                              <button class="btn btn-danger btn-sm">Deletar</button>
                              <button class="btn btn-info btn-sm">Inspecionar</button>
                          </td>
                      </tr>
                      <!-- Registro 5 -->
                      <tr>
                          <td>005</td>
                          <td>Ginecologia</td>
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