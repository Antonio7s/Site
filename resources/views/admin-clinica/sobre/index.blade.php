@extends('layouts.painel-clinica')
@section('header_title', 'Editar Clínica')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<style>
  .section-title {
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 0.5rem;
    margin: 2rem 0 1.5rem;
  }
  .required-asterisk {
    color: #e74c3c;
    font-size: 0.8em;
  }
  .documento-atual {
    font-size: 0.9em;
    color: #7f8c8d;
  }
</style>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h4 class="m-0 font-weight-bold text-primary">Editar Cadastro da Clínica</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('clinica.info.update', $clinica->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Seção: Dados da Clínica -->
        <h3 class="section-title">Dados da Clínica</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="razao_social" class="form-label">Razão Social <span class="required-asterisk">*</span></label>
              <input type="text" id="razao_social" class="form-control" name="razao_social" 
                     value="{{ old('razao_social', $clinica->razao_social) }}" required>
              @error('razao_social')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nome_fantasia" class="form-label">Nome Fantasia <span class="required-asterisk">*</span></label>
              <input type="text" id="nome_fantasia" class="form-control" name="nome_fantasia" 
                     value="{{ old('nome_fantasia', $clinica->nome_fantasia) }}" required>
              @error('nome_fantasia')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="cnpj_cpf" class="form-label">CNPJ/CPF <span class="required-asterisk">*</span></label>
              <input type="text" id="cnpj_cpf" class="form-control" name="cnpj_cpf" 
                     value="{{ old('cnpj_cpf', $clinica->cnpj_cpf) }}" required>
              @error('cnpj_cpf')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="telefone" class="form-label">Telefone <span class="required-asterisk">*</span></label>
              <input type="text" id="telefone" class="form-control" name="telefone" 
                     value="{{ old('telefone', $clinica->telefone) }}" required>
              @error('telefone')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="email" class="form-label">Email <span class="required-asterisk">*</span></label>
              <input type="email" id="email" class="form-control" name="email" 
                     value="{{ old('email', $clinica->email) }}" required>
              @error('email')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <!-- Seção: Endereço -->
        <h3 class="section-title">Localização</h3>
        <div class="row">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="cep" class="form-label">CEP <span class="required-asterisk">*</span></label>
              <input type="text" id="cep" class="form-control" name="cep" 
                     value="{{ old('cep', $clinica->cep) }}" required>
              @error('cep')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-5">
            <div class="mb-3">
              <label for="endereco" class="form-label">Endereço <span class="required-asterisk">*</span></label>
              <input type="text" id="endereco" class="form-control" name="endereco" 
                     value="{{ old('endereco', $clinica->endereco) }}" required>
              @error('endereco')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label for="numero" class="form-label">Número <span class="required-asterisk">*</span></label>
              <input type="text" id="numero" class="form-control" name="numero" 
                     value="{{ old('numero', $clinica->numero) }}" required>
              @error('numero')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" id="complemento" class="form-control" name="complemento" 
                     value="{{ old('complemento', $clinica->complemento) }}">
              @error('complemento')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="bairro" class="form-label">Bairro <span class="required-asterisk">*</span></label>
              <input type="text" id="bairro" class="form-control" name="bairro" 
                     value="{{ old('bairro', $clinica->bairro) }}" required>
              @error('bairro')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="cidade" class="form-label">Cidade <span class="required-asterisk">*</span></label>
              <input type="text" id="cidade" class="form-control" name="cidade" 
                     value="{{ old('cidade', $clinica->cidade) }}" required>
              @error('cidade')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="uf" class="form-label">UF <span class="required-asterisk">*</span></label>
              <select id="uf" name="uf" class="form-select" required>
                @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                  <option value="{{ $uf }}" {{ old('uf', $clinica->uf) == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                @endforeach
              </select>
              @error('uf')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <!-- Seção: Contatos -->
        <h3 class="section-title">Contatos</h3>
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="telefone_local" class="form-label">Telefone Local <span class="required-asterisk">*</span></label>
              <input type="text" id="telefone_local" class="form-control" name="telefone_local" 
                     value="{{ old('telefone_local', $clinica->telefone_local) }}" required>
              @error('telefone_local')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="telefone_financeiro" class="form-label">Telefone Financeiro <span class="required-asterisk">*</span></label>
              <input type="text" id="telefone_financeiro" class="form-control" name="telefone_financeiro" 
                     value="{{ old('telefone_financeiro', $clinica->telefone_financeiro) }}" required>
              @error('telefone_financeiro')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="celular" class="form-label">Celular <span class="required-asterisk">*</span></label>
              <input type="text" id="celular" class="form-control" name="celular" 
                     value="{{ old('celular', $clinica->celular) }}" required>
              @error('celular')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <!-- Seção: Responsável -->
        <h3 class="section-title">Responsável pelo Contrato</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="responsavel_nome" class="form-label">Nome Completo <span class="required-asterisk">*</span></label>
              <input type="text" id="responsavel_nome" class="form-control" name="responsavel_nome" 
                     value="{{ old('responsavel_nome', $clinica->responsavel_nome) }}" required>
              @error('responsavel_nome')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="rg" class="form-label">RG <span class="required-asterisk">*</span></label>
              <input type="text" id="rg" class="form-control" name="rg" 
                     value="{{ old('rg', $clinica->rg) }}" required>
              @error('rg')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="orgao_emissor" class="form-label">Órgão Emissor <span class="required-asterisk">*</span></label>
              <input type="text" id="orgao_emissor" class="form-control" name="orgao_emissor" 
                     value="{{ old('orgao_emissor', $clinica->orgao_emissor) }}" required>
              @error('orgao_emissor')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="data_emissao" class="form-label">Data Emissão <span class="required-asterisk">*</span></label>
              <input type="text" id="data_emissao" class="form-control" name="data_emissao" 
                     value="{{ old('data_emissao', $clinica->data_emissao) }}" required>
              @error('data_emissao')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="cpf" class="form-label">CPF <span class="required-asterisk">*</span></label>
              <input type="text" id="cpf" class="form-control" name="cpf" 
                     value="{{ old('cpf', $clinica->cpf) }}" required>
              @error('cpf')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="estado_civil" class="form-label">Estado Civil <span class="required-asterisk">*</span></label>
              <input type="text" id="estado_civil" class="form-control" name="estado_civil" 
                     value="{{ old('estado_civil', $clinica->estado_civil) }}" required>
              @error('estado_civil')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <!-- Seção: Segurança -->
        <h3 class="section-title">Segurança</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="password" class="form-label">Nova Senha</label>
              <input type="password" id="password" class="form-control" name="password">
              <small class="text-muted">Deixe em branco para manter a senha atual</small>
              @error('password')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
              <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
              @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <!-- Seção: Documentos -->
        <h3 class="section-title">Documentos</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="documentos" class="form-label">Atualizar Documento (PDF)</label>
              <input type="file" id="documentos" class="form-control" name="documentos" accept="application/pdf">
              @if($clinica->documentos)
                <div class="documento-atual mt-2">
                  Documento atual: <a href="{{ asset('storage/' . $clinica->documentos) }}" target="_blank">Visualizar</a>
                </div>
              @endif
              @error('documentos')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <!-- Seção: Pagamento -->
        <!-- <h3 class="section-title">Pagamento</h3>
            <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                <label for="wallet_id" class="form-label">Wallet id do Asaas<span class="required-asterisk">*</span></label>
                <input type="text" id="wallet_id" class="form-control" name="wallet_id" 
                        value="{{ old('wallet_id', $clinica->wallet_id) }}">
                @error('wallet_id')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>
        </div> -->

        <!-- Botão de Atualização -->
        <div class="d-flex justify-content-end mt-5">
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save me-2"></i> Atualizar Cadastro
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    // Aplicar máscaras
    $('#telefone_local').mask('(00) 0000-0000');
    $('#telefone_financeiro').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#data_emissao').mask('00/00/0000');
    $('#cep').mask('00000-000');
  });
</script>
@endsection