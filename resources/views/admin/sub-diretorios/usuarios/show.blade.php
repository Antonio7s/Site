@extends('layouts.painel-admin')
@section('header_title', 'Análise de Registro de Usuários') <!-- Alterando o título para contexto de usuários -->
@section('content')
    <!-- CORPO -->
    <div class="row mt-4 ms-2">
                
        <!-- Informações do Usuário -->
        <form>
            <h3>Dados do Usuário</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" value="{{ $user->name ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail</label>
                    <input type="text" class="form-control" value="{{ $user->email ?? 'Não informado' }}" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">CPF</label>
                    <input type="text" class="form-control" value="{{ $user->cpf ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Telefone</label>
                    <input type="text" class="form-control" value="{{ $user->telefone ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data de Nascimento</label>
                    <input type="text" class="form-control" value="{{ $user->data_nascimento ?? 'Não informado' }}" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Foto de Perfil</label>
                    <input type="text" class="form-control" value="{{ $user->photo_url ?? 'Não informado' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nível de Acesso</label>
                    <input type="text" class="form-control" value="{{ $user->access_level ?? 'Não informado' }}" readonly>
                </div>
            </div>
        </form>
        <hr class="my-4">
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-success">Voltar</a>
        </div>
    </div>
@endsection
