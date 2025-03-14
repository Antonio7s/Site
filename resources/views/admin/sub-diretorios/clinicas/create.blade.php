@extends('layouts.painel-admin')
@section('header_title', 'Registro de clínica') <!-- Alterando o h1 -->
@section('content')
        <!-- CORPO -->
            <div class="row mt-4 ms-2"> <!--espacamento na esquerda para nao ficar junto com a navbar-->
              <div class="tab-pane fade show active" id="cadastro-completo" role="tabpanel">
                <div class="form-section">
                    <h3>Ficha Cadastral de clinica</h3>
                    <!-- Formulário de Cadastro Completo -->
                    <form>
                        <!-- Informações Básicas -->
                        <h4 class="mb-3">Informações Básicas</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" placeholder="00.000.000/0000-00" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="razaoSocial" class="form-label">Razão Social</label>
                                <input type="text" class="form-control" id="razaoSocial" placeholder="Informe a razão social" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nomeFantasia" class="form-label">Nome Fantasia (Nome de Divulgação)</label>
                                <input type="text" class="form-control" id="nomeFantasia" placeholder="Informe o nome fantasia" required>
                            </div>
                        </div>
                        <hr>
                        <!-- Endereço -->
                        <h4 class="mb-3">Endereço</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="cep" placeholder="00000-000" required>
                            </div>
                            <div class="col-md-8">
                                <label for="endereco" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="endereco" placeholder="Informe o endereço completo" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" placeholder="Nº" required>
                            </div>
                            <div class="col-md-5">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="complemento" placeholder="Apto, Bloco, etc">
                            </div>
                            <div class="col-md-4">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" placeholder="Informe o bairro" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" placeholder="Informe a cidade" required>
                            </div>
                            <div class="col-md-3">
                                <label for="uf" class="form-label">UF</label>
                                <select id="uf" class="form-select" required>
                                    <option selected disabled>Selecione...</option>
                                    <option>AC</option>
                                    <option>AL</option>
                                    <option>AP</option>
                                    <option>AM</option>
                                    <option>BA</option>
                                    <option>CE</option>
                                    <option>DF</option>
                                    <option>ES</option>
                                    <option>GO</option>
                                    <option>MA</option>
                                    <option>MT</option>
                                    <option>MS</option>
                                    <option>MG</option>
                                    <option>PA</option>
                                    <option>PB</option>
                                    <option>PR</option>
                                    <option>PE</option>
                                    <option>PI</option>
                                    <option>RJ</option>
                                    <option>RN</option>
                                    <option>RS</option>
                                    <option>RO</option>
                                    <option>RR</option>
                                    <option>SC</option>
                                    <option>SP</option>
                                    <option>SE</option>
                                    <option>TO</option>
                                </select>
                            </div>
                        </div>
                        
                        <hr>

                        <!-- Contatos -->
                        <h4 class="mb-3">Contatos</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="emailAdmin" class="form-label">E-mail Administrativo</label>
                                <input type="email" class="form-control" id="emailAdmin" placeholder="exemplo@admin.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="emailFaturamento" class="form-label">E-mail Faturamento</label>
                                <input type="email" class="form-control" id="emailFaturamento" placeholder="exemplo@faturamento.com" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="telLocal" class="form-label">Telefone Local de Atendimento (DDD)</label>
                                <input type="tel" class="form-control" id="telLocal" placeholder="(00) 0000-0000" required>
                            </div>
                            <div class="col-md-4">
                                <label for="telFinanceiro" class="form-label">Telefone Financeiro (DDD)</label>
                                <input type="tel" class="form-control" id="telFinanceiro" placeholder="(00) 0000-0000">
                            </div>
                            <div class="col-md-4">
                                <label for="celular" class="form-label">Celular (DDD)</label>
                                <input type="tel" class="form-control" id="celular" placeholder="(00) 90000-0000" required>
                            </div>
                        </div>
                        
                        <hr>

                        <!-- Responsável por Assinar o Contrato -->
                        <h4 class="mb-3">Responsável pelo Contrato</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomeResponsavel" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nomeResponsavel" placeholder="Informe o nome completo" required>
                            </div>
                            <div class="col-md-3">
                                <label for="rgResponsavel" class="form-label">RG</label>
                                <input type="text" class="form-control" id="rgResponsavel" placeholder="Informe o RG" required>
                            </div>
                            <div class="col-md-3">
                                <label for="orgaoEmissor" class="form-label">Órgão Emissor</label>
                                <input type="text" class="form-control" id="orgaoEmissor" placeholder="Informe o órgão emissor" required>
                            </div>

                            <!-- DATA DA EMISSAO -->
                            <!-- CPF DO RESPONSAVEL PELO CONTRATO -->
                            <!-- ESTADO CIVIL DO RESPONSAVEL PELO CONTRATO -->

                        </div>
        
                        <hr>

                        <!-- Dados Bancários
                        <h4 class="mb-3">Dados Bancários</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="banco" class="form-label">Banco</label>
                                <input type="text" class="form-control" id="banco" placeholder="Informe o nome do banco" required>
                            </div>
                            <div class="col-md-2">
                                <label for="numeroBanco" class="form-label">Nº do Banco</label>
                                <input type="text" class="form-control" id="numeroBanco" placeholder="000" required>
                            </div>
                            <div class="col-md-3">
                                <label for="agencia" class="form-label">Agência (com dígito)</label>
                                <input type="text" class="form-control" id="agencia" placeholder="0000-0000" required>
                            </div>
                            <div class="col-md-3">
                                <label for="contaCorrente" class="form-label">Conta Corrente (com dígito)</label>
                                <input type="text" class="form-control" id="contaCorrente" placeholder="00000-0" required>
                            </div>
                        </div> -->
        
                        <!-- Botão de Envio -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
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