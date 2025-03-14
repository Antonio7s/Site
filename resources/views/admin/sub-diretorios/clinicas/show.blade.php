@extends('layouts.painel-admin')
@section('header_title', 'Análise de registro de clínicas') <!-- Alterando o h1 -->
@section('content')
        <!-- CORPO -->
            <div class="row mt-4 ms-2">
                
                <!-- Informações da Clínica -->
                <form>
                    <h3>Dados da Clínica</h3>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $clinica->status) }}" readonly>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">CNPJ</label>
                            <input type="text" class="form-control" value="{{ $clinica->cnpj_cpf ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Razão Social</label>
                            <input type="text" class="form-control" value="{{ $clinica->razao_social ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nome Fantasia (Nome para divulgação)</label>
                            <input type="text" class="form-control" value="{{ $clinica->nome_fantasia ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">CEP</label>
                            <input type="text" class="form-control" value="{{ $clinica->cep ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Endereço</label>
                            <input type="text" class="form-control" value="{{ $clinica->endereco ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Número</label>
                            <input type="text" class="form-control" value="{{ $clinica->numero ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Complemento</label>
                            <input type="text" class="form-control" value="{{ $clinica->complemento ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Bairro</label>
                            <input type="text" class="form-control" value="{{ $clinica->bairro ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cidade</label>
                            <input type="text" class="form-control" value="{{ $clinica->cidade ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">UF</label>
                            <select class="form-select" disabled>
                                <option selected>{{ $clinica->uf ?? 'Não informado' }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">E-mail Administrativo</label>
                            <input type="text" class="form-control" value="{{ $clinica->email_administrativo ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-mail Faturamento</label>
                            <input type="text" class="form-control" value="{{ $clinica->email_faturamento ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Telefone do Local (DDD)</label>
                            <input type="text" class="form-control" value="{{ $clinica->telefone_local ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Telefone Financeiro (DDD)</label>
                            <input type="text" class="form-control" value="{{ $clinica->telefone_financeiro ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Celular (DDD)</label>
                            <input type="text" class="form-control" value="{{ $clinica->celular ?? 'Não informado' }}" readonly>
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
                            <input type="text" class="form-control" value="{{ $clinica->responsavel_nome ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">RG</label>
                            <input type="text" class="form-control" value="{{ $clinica->rg ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Órgão Emissor</label>
                            <input type="text" class="form-control" value="{{ $clinica->orgao_emissor ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Data de Emissão</label>
                            <input type="text" class="form-control" value="{{ $clinica->data_emissao ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CPF</label>
                            <input type="text" class="form-control" value="{{ $clinica->responsavel_cpf ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado Civil</label>
                            <input type="text" class="form-control" value="{{ $clinica->estado_civil ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                </form>

                <!-- Dados Bancários -->
                <!-- <hr class="my-4">
                <form>
                    <h3>Dados Bancários</h3>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Banco</label>
                            <input type="text" class="form-control" value="{{ $clinica->modificar ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Nº Banco</label>
                            <input type="text" class="form-control" value="{{ $clinica->modificar ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Agência</label>
                            <input type="text" class="form-control" value="{{ $clinica->modificar ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Conta Corrente</label>
                            <input type="text" class="form-control" value="{{ $clinica->modificar ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Titular da Conta</label>
                            <input type="text" class="form-control" value="{{ $clinica->modificar ?? 'Não informado' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chave PIX</label>
                            <input type="text" class="form-control" value="{{ $clinica->modificar ?? 'Não informado' }}" readonly>
                        </div>
                    </div>
                </form> -->

                <!-- Seção de Documentos -->
                <hr class="my-4">
                <h3>Documentos para Download</h3>
                <ul class="list-group">
                    <li class="list-group-item">Documentos <a href="{{ route('admin.clinicas.download', $clinica->id) }}" class="btn btn-link btn-sm">Download</a></li>
                </ul>


                <!-- Secao de Taxa de Servicos -->
                 
                <hr class="my4">
                <h3> Taxa de Serviço da MedExame </h3>
                <div class="col-md-2">
                            <label class="form-label">Taxa em %</label>
                            <input type="text" class="form-control" value="{{ $clinica->porcentagem_lucro ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-2">
                            <label class="form-label">Taxa fixa EM R$</label>
                            <input type="text" class="form-control" value="{{ $clinica->valor_fixo_lucro ?? 'Não informado' }}" readonly>
                </div>

                <div class="col-md-2">
                            <label class="form-label">Wallet_Id da Cl</label>
                            <input type="text" class="form-control" value="{{ $clinica->wallet_id ?? 'Não informado' }}" readonly>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.clinicas.index') }}" class="btn btn-success">Voltar</a>
                    
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