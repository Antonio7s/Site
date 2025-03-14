@extends('layouts.painel-admin')
@section('header_title', 'Análise de registro de clínicas')
@section('content')
    <div class="row mt-4 ms-2">
        
        <!-- Informações da Clínica -->
        <form>
            <h3>Dados da Clínica</h3>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $clinica->status) }}" readonly>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">CNPJ</label>
                    <input type="text" class="form-control" value="{{ $clinica->cnpj ?? 'Não informado' }}" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">CNES (Número)</label>
                    <input type="text" class="form-control" value="{{ $clinica->cnes ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Razão Social</label>
                    <input type="text" class="form-control" value="{{ $clinica->razao_social ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nome Fantasia</label>
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
                    <input type="text" class="form-control" value="{{ $clinica->cpf ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado Civil</label>
                    <input type="text" class="form-control" value="{{ $clinica->estado_civil ?? 'Não informado' }}" readonly>
                </div>
            </div>
        </form>

        <!-- Dados Bancários
        <hr class="my-4">
        <form>
            <h3>Dados Bancários</h3>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Banco</label>
                    <input type="text" class="form-control" value="{{ $clinica->banco ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nº Banco</label>
                    <input type="text" class="form-control" value="{{ $clinica->numero_banco ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Agência</label>
                    <input type="text" class="form-control" value="{{ $clinica->agencia ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Conta Corrente</label>
                    <input type="text" class="form-control" value="{{ $clinica->conta_corrente ?? 'Não informado' }}" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Titular da Conta</label>
                    <input type="text" class="form-control" value="{{ $clinica->titular_conta ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Chave PIX</label>
                    <input type="text" class="form-control" value="{{ $clinica->chave_pix ?? 'Não informado' }}" readonly>
                </div>
            </div>
        </form> -->

        <!-- Seção de Documentos -->
        <hr class="my-4">
        <h3>Documentos para Download</h3>
        <ul class="list-group">
            <li class="list-group-item">
                Documento: {{ $clinica->documentos ?? 'Documento não enviado' }}
                @if($clinica->documentos)
                    <a href="{{ route('admin.clinicas.download', $clinica->id) }}" class="btn btn-link btn-sm">Download</a>
                @endif
            </li>
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

        <!-- Botões de Ação -->
        <div class="d-flex justify-content-end mt-4">
            <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#emailModal">Entrar em Contato</button>
            <form action="{{ route('admin.clinicas.solicitacoes-de-cadastro.analise', $clinica->id) }}" method="POST">
                @csrf
                <button type="submit" name="acao" value="aprovar" class="btn btn-success">Aceitar</button>
                <button type="submit" name="acao" value="negar" class="btn btn-danger">Negar</button>
            </form>
        </div>
    </div>

    <!-- Modal de Contato -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Contato - Clínica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>
                        E-mail:
                        <a id="clinicEmailLink" href="#" target="_blank">{{ $clinica->email_administrativo ?? 'Não informado' }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para montar a URL do Gmail -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var email = "{{ $clinica->email_administrativo ?? 'admin@exemplo.com' }}";
            var assunto = "Envio de Documentos Faltantes";
            var corpo = "Prezado(a),\n\nFavor enviar os documentos faltantes conforme a lista:\n- Documento A\n- Documento B\n- Documento C\n\nAtenciosamente,\nMedExame";
            var subjectEncoded = encodeURIComponent(assunto);
            var bodyEncoded = encodeURIComponent(corpo);
            var gmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" + email + "&su=" + subjectEncoded + "&body=" + bodyEncoded;
            document.getElementById('clinicEmailLink').setAttribute('href', gmailUrl);
        });
    </script>
@endsection
