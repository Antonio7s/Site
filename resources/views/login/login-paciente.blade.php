@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #f4f6f9;">
    <div class="card shadow p-4 text-center" style="width: 400px; border-radius: 12px;">
        <h3 class="fw-bold text-primary mb-3">Login</h3>

        <!-- Formulário de Login -->
        <form>
            <div class="mb-3">
                <input type="email" class="form-control py-2" placeholder="E-mail" style="border-radius: 8px;">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control py-2" placeholder="Senha" style="border-radius: 8px;">
                <!-- Botão "Esqueci a senha" -->
                <div class="text-end mt-2">
                    <button type="button" class="btn btn-link p-0" style="font-size: 0.8rem;">Esqueci a senha</button>
                </div>
            </div>

            <!-- reCAPTCHA (Sou robô) -->
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="SUA_CHAVE_DO_RECAPTCHA_AQUI"></div>
            </div>

            <!-- Botão "Acessar" -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 8px;">
                    Acessar
                </button>
            </div>

            <!-- Divisor -->
            <div class="position-relative my-4">
                <hr>
                <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted">ou</span>
            </div>

            <!-- Botão "Entrar com Google" -->
            <div class="mb-3">
                <button type="button" class="btn btn-outline-danger w-100 py-2" style="border-radius: 8px;">
                    <i class="bi bi-google me-2"></i> Entrar com Google
                </button>
            </div>

            <!-- Botão "Entrar com Facebook" -->
            <div class="mb-3">
                <button type="button" class="btn btn-outline-primary w-100 py-2" style="border-radius: 8px;">
                    <i class="bi bi-facebook me-2"></i> Entrar com Facebook
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
