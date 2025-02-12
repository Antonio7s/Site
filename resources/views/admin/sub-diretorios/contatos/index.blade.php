@extends('layouts.painel-admin')
@section('header_title', 'Contatos') <!-- Alterando o h1 -->
@section('content')
        <!-- CORPO -->
            <div class="row mt-4 ms-2">
                    <div class="form-section">
                        <h3>Informe os Contatos</h3>
                        <form id="formContato">
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" id="facebook" class="form-control" placeholder="Insira o link do Facebook">
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" id="instagram" class="form-control" placeholder="Insira o link do Instagram">
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="text" id="twitter" class="form-control" placeholder="Insira o link do Twitter">
                            </div>
                            <div class="mb-3">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="text" id="whatsapp" class="form-control" placeholder="Insira o número do WhatsApp">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
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