@extends('layouts.painel-admin')
@section('header_title', 'Análise de registro de clínicas') <!-- Alterando o h1 -->
@section('content')
<!-- CORPO -->
    <div class="row mt-4 ms-2">
        <form method="POST" action="{{ route('admin.clinicas.update', $clinica->id) }}">
            @csrf
            @method('PUT') <!-- Especifica que estamos fazendo uma atualização -->

            <h3>Dados da Clínica</h3>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" name="status">
                    <option value="" disabled {{ old('status', $clinica->status) == '' ? 'selected' : '' }}>Selecione o status</option>
                    <option value="ativo" {{ old('status', $clinica->status) == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                    <option value="inativo" {{ old('status', $clinica->status) == 'negado' ? 'selected' : '' }}>Negado</option>
                    <option value="pendente" {{ old('status', $clinica->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


                <div class="col-md-6">
                    <label class="form-label">CNPJ</label>
                    <input type="text" class="form-control @error('cnpj_cpf') is-invalid @enderror" name="cnpj_cpf" value="{{ old('cnpj_cpf', $clinica->cnpj_cpf) }}">
                    @error('cnpj_cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Razão Social</label>
                    <input type="text" class="form-control @error('razao_social') is-invalid @enderror" name="razao_social" value="{{ old('razao_social', $clinica->razao_social) }}">
                    @error('razao_social')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nome Fantasia</label>
                    <input type="text" class="form-control @error('nome_fantasia') is-invalid @enderror" name="nome_fantasia" value="{{ old('nome_fantasia', $clinica->nome_fantasia) }}">
                    @error('nome_fantasia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">CEP</label>
                    <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep', $clinica->cep) }}">
                    @error('cep')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5">
                    <label class="form-label">Endereço</label>
                    <input type="text" class="form-control @error('endereco') is-invalid @enderror" name="endereco" value="{{ old('endereco', $clinica->endereco) }}">
                    @error('endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Número</label>
                    <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero', $clinica->numero) }}">
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Complemento</label>
                    <input type="text" class="form-control @error('complemento') is-invalid @enderror" name="complemento" value="{{ old('complemento', $clinica->complemento) }}">
                    @error('complemento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Bairro</label>
                    <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" value="{{ old('bairro', $clinica->bairro) }}">
                    @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cidade</label>
                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" value="{{ old('cidade', $clinica->cidade) }}">
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">UF</label>
                    <select class="form-select @error('uf') is-invalid @enderror" name="uf" disabled>
                        <option selected>{{ old('uf', $clinica->uf) }}</option>
                    </select>
                    @error('uf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            <!-- Contatos -->
            <h4 class="mb-3">Contatos</h4>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">E-mail Administrativo</label>
                    <input type="email" class="form-control @error('email_administrativo') is-invalid @enderror" name="email_administrativo" value="{{ old('email_administrativo', $clinica->email_administrativo) }}">
                    @error('email_administrativo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail Faturamento</label>
                    <input type="email" class="form-control @error('email_faturamento') is-invalid @enderror" name="email_faturamento" value="{{ old('email_faturamento', $clinica->email_faturamento) }}">
                    @error('email_faturamento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Telefone do Local (DDD)</label>
                    <input type="text" class="form-control @error('telefone_local') is-invalid @enderror" name="telefone_local" value="{{ old('telefone_local', $clinica->telefone_local) }}">
                    @error('telefone_local')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Telefone Financeiro (DDD)</label>
                    <input type="text" class="form-control @error('telefone_financeiro') is-invalid @enderror" name="telefone_financeiro" value="{{ old('telefone_financeiro', $clinica->telefone_financeiro) }}">
                    @error('telefone_financeiro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Celular (DDD)</label>
                    <input type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular', $clinica->celular) }}">
                    @error('celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h3>Responsável pelo Contrato</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('responsavel_nome') is-invalid @enderror" name="responsavel_nome" value="{{ old('responsavel_nome', $clinica->responsavel_nome) }}">
                    @error('responsavel_nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">RG</label>
                    <input type="text" class="form-control @error('rg') is-invalid @enderror" name="rg" value="{{ old('rg', $clinica->rg) }}">
                    @error('rg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Órgão Emissor</label>
                    <input type="text" class="form-control @error('orgao_emissor') is-invalid @enderror" name="orgao_emissor" value="{{ old('orgao_emissor', $clinica->orgao_emissor) }}">
                    @error('orgao_emissor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Data de Emissão</label>
                    <input type="text" class="form-control @error('data_emissao') is-invalid @enderror" name="data_emissao" value="{{ old('data_emissao', $clinica->data_emissao) }}">
                    @error('data_emissao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">CPF</label>
                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf', $clinica->cpf) }}">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado Civil</label>
                    <input type="text" class="form-control @error('estado_civil') is-invalid @enderror" name="estado_civil" value="{{ old('estado_civil', $clinica->estado_civil) }}">
                    @error('estado_civil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <!-- TEMPORIAMENTE DESATIVADO 
            <h3>Dados Bancários</h3>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Banco</label>
                    <input type="text" class="form-control @error('banco') is-invalid @enderror" name="banco" value="{{ old('banco', $clinica->banco) }}">
                    @error('banco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nº Banco</label>
                    <input type="text" class="form-control @error('numero_banco') is-invalid @enderror" name="numero_banco" value="{{ old('numero_banco', $clinica->numero_banco) }}">
                    @error('numero_banco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Agência</label>
                    <input type="text" class="form-control @error('agencia') is-invalid @enderror" name="agencia" value="{{ old('agencia', $clinica->agencia) }}">
                    @error('agencia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Conta Corrente</label>
                    <input type="text" class="form-control @error('conta_corrente') is-invalid @enderror" name="conta_corrente" value="{{ old('conta_corrente', $clinica->conta_corrente) }}">
                    @error('conta_corrente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Titular da Conta</label>
                    <input type="text" class="form-control @error('titular_conta') is-invalid @enderror" name="titular_conta" value="{{ old('titular_conta', $clinica->titular_conta) }}">
                    @error('titular_conta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">CPF do Titular</label>
                    <input type="text" class="form-control @error('cpf_titular') is-invalid @enderror" name="cpf_titular" value="{{ old('cpf_titular', $clinica->cpf_titular) }}">
                    @error('cpf_titular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            fim do comentario-->


            <!-- Senha -->
            <h3>Alterar Senha (Opcional)</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nova Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Deixe em branco para não alterar">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Seção de Documentos -->
            <hr class="my-4">
            <div>
            <h3>Documentos para Download</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        Documento: {{ $clinica->documentos }} 
                        <a href="{{ route('admin.clinicas.download', $clinica->id) }}" class="btn btn-primary">
                            Baixar Documento
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Seção de Taxas -->
            <hr class="my4">
            <div>
                <h3> Taxa de Serviço da MedExame </h3>
                <div class="col-md-2">
                            <label class="form-label">Taxa em %</label>
                            <input type="text" class="form-control" value="{{ $clinica->porcentagem_lucroficar ?? 'Não informado' }}" >
                </div>
                <div class="col-md-2">
                            <label class="form-label">Taxa fixa EM R$</label>
                            <input type="text" class="form-control" value="{{ $clinica->valor_fixo_lucro ?? 'Não informado' }}" >
                </div>

                <div class="col-md-2">
                            <label class="form-label">Wallet Id da Clínica</label>
                            <input type="text" class="form-control" value="{{ $clinica->wallet_id ?? 'Não informado' }}" >
                </div>
            </div>

            <!-- BOTOES -->
            <div class="d-flex justify-content-end mt-4">
                <button type="reset" class="btn btn-warning">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
@endsection
