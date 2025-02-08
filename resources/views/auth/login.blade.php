@extends('layouts.layout-index')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background-color: #f4f6f9; padding-top: 20px; padding-bottom: 20px;">
    <div class="card shadow-sm p-4 text-center" style="width: 380px; border-radius: 10px;">
        <h4 class="fw-bold text-primary mb-3">Login</h4>

        <!-- Formulário de Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- E-mail -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label fw-semibold">E-mail</label>
                <input type="email" name="email" id="email" class="form-control py-2" placeholder="Digite seu e-mail" required>
            </div>

            <!-- Senha -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label fw-semibold">Senha</label>
                <input type="password" name="password" id="password" class="form-control py-2" placeholder="Digite sua senha" required>
                <!-- Link "Esqueci a senha" -->
                <div class="text-end mt-2">
                    <a href="{{route('password.request')}}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">Esqueci a senha</a>
                </div>
            </div>

            <!-- Botão "Acessar" -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary py-2">Acessar</button>
            </div>

            <!-- Divisor -->
            <div class="position-relative my-3">
                <hr>
                <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted">ou</span>
            </div>

            <!-- Botão "Entrar com Google" -->
            <div class="mb-2">
                <button type="button" class="btn btn-outline-danger w-100 py-2">
                    <i class="bi bi-google me-2"></i> Entrar com Google
                </button>
            </div>

            <!-- Botão "Entrar com Facebook" -->
            <div class="mb-3">
                <button type="button" class="btn btn-outline-primary w-100 py-2">
                    <i class="bi bi-facebook me-2"></i> Entrar com Facebook
                </button>
            </div>

            <!-- Link para Cadastro -->
            <div class="text-center">
                <small>Ainda não tem uma conta? <a href="{{ route('register') }}" class="text-decoration-none">Cadastre-se</a></small>
            </div>
        </form>
    </div>
</div>
@endsection
