@extends('layouts.painel-admin')
@section('header_title', 'Edição de Registro de Usuário') <!-- Alterando o h1 -->
@section('content')
<!-- CORPO -->
    <div class="row mt-4 ms-2">
        <form method="POST" action="{{ route('user.update', $user->id) }}">
            @csrf
            @method('PUT') <!-- Especifica que estamos fazendo uma atualização -->

            <h3>Dados do Usuário</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">CPF</label>
                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf', $user->cpf) }}">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone', $user->telefone) }}">
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" name="data_nascimento" value="{{ old('data_nascimento', $user->data_nascimento) }}">
                    @error('data_nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nível de Acesso</label>
                    <select class="form-select @error('access_level') is-invalid @enderror" name="access_level">
                        <option value="admin" {{ $user->access_level == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="user" {{ $user->access_level == 'user' ? 'selected' : '' }}>Usuário</option>
                        <option value="moderator" {{ $user->access_level == 'moderator' ? 'selected' : '' }}>Moderador</option>
                    </select>
                    @error('access_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

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


            <!-- BOTOES -->
            <div class="d-flex justify-content-end mt-4">
                <button type="reset" class="btn btn-warning">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
@endsection
