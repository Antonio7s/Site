@extends('layouts.painel-admin')
@section('header_title', 'Análise de registro de clínicas') <!-- Alterando o h1 -->
@section('content')
        <!-- CORPO -->
            <div class="row mt-4 ms-2">
                
                <!-- Informações da Clínica -->
                <form>
                    <h3>Dados da Clínica</h3>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ficha Cadastral</label>
                            <input type="text" class="form-control" value="Ficha Cadastral de Profissionais Médicos" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CNPJ</label>
                            <input type="text" class="form-control" value="12.345.678/0001-99" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Razão Social</label>
                            <input type="text" class="form-control" value="{{ $clinica->razao_social ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nome Fantasia (Nome para divulgação)</label>
                            <input type="text" class="form-control" value="Saúde Nova" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">CEP</label>
                            <input type="text" class="form-control" value="12345-678" readonly>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Endereço</label>
                            <input type="text" class="form-control" value="Rua Central, 45" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Número</label>
                            <input type="text" class="form-control" value="45" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Complemento</label>
                            <input type="text" class="form-control" value="Sala 201" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Bairro</label>
                            <input type="text" class="form-control" value="Centro" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cidade</label>
                            <input type="text" class="form-control" value="São Paulo" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">UF</label>
                            <select class="form-select" disabled>
                                <option selected>SP</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">E-mail Administrativo</label>
                            <input type="text" class="form-control" value="admin@saudenova.com" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-mail Faturamento</label>
                            <input type="text" class="form-control" value="financeiro@saudenova.com" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Telefone do Local (DDD)</label>
                            <input type="text" class="form-control" value="(11) 2345-6789" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Telefone Financeiro (DDD)</label>
                            <input type="text" class="form-control" value="(11) 9876-5432" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Celular (DDD)</label>
                            <input type="text" class="form-control" value="(11) 91234-5678" readonly>
                        </div>
                    </div>
                </form>

                    <!-- Dados do Responsável pelo Contrato -->
                <hr class="my-4">
                <form>
                    <h3>Responsável pelo Contrato</h3>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" value="João Silva" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">RG</label>
                            <input type="text" class="form-control" value="12345678" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Órgão Emissor</label>
                            <input type="text" class="form-control" value="SSP-SP" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Data de Emissão</label>
                            <input type="text" class="form-control" value="10/10/2015" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control" value="123.456.789-00" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado Civil</label>
                            <input type="text" class="form-control" value="Casado" readonly>
                        </div>
                    </div>
                </form>

                <!-- Dados Bancários -->
                <hr class="my-4">
                <form>
                    <h3>Dados Bancários</h3>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Banco</label>
                            <input type="text" class="form-control" value="Banco do Brasil" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Nº Banco</label>
                            <input type="text" class="form-control" value="001" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Agência</label>
                            <input type="text" class="form-control" value="1234-5" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Conta Corrente</label>
                            <input type="text" class="form-control" value="67890-1" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Titular da Conta</label>
                            <input type="text" class="form-control" value="Clínica Saúde Nova" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chave PIX</label>
                            <input type="text" class="form-control" value="cnpj@saudenova.com" readonly>
                        </div>
                    </div>
                </form>

                <!-- Seção de Documentos -->
                <hr class="my-4">
                <h3>Documentos para Download</h3>
                <ul class="list-group">
                    <li class="list-group-item">Documentos <a href="#" class="btn btn-link btn-sm">Download</a></li>
                </ul>

                <hr class="my4">
                <h3> Taxa de Serviço da MedExame </h3>
                <div class="col-md-2">
                            <label class="form-label">Taxa em %</label>
                            <input type="text" class="form-control" value="5%" readonly>
                </div>
                <div class="col-md-2">
                            <label class="form-label">Taxa fixa EM R$</label>
                            <input type="text" class="form-control" value="R$5,00" readonly>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-success">Voltar</button>
                    
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