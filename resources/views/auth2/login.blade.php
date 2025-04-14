@extends('layouts.layout-index') 

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background-color: #f4f6f9; padding-top: 20px; padding-bottom: 20px;">
    <div class="card shadow-sm p-4 text-center" style="width: 380px; border-radius: 10px;">
        <h4 class="fw-bold text-primary mb-3">Login</h4>

        <!-- Bloco de exibição de erros -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>
                            @if($error == 'The email field is required.')
                                O campo e-mail é obrigatório.
                            @elseif($error == 'The password field is required.')
                                O campo senha é obrigatório.
                            @elseif($error == 'The email must be a valid email address.')
                                Por favor, insira um e-mail válido.
                            @elseif($error == 'These credentials do not match our records.')
                                E-mail ou senha incorretos.
                            @else
                                {{ $error }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário de Login -->
        <form method="POST" action="{{ route('login2') }}">
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
                    <a href="{{ route('password.request2') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">Esqueci a senha</a>
                </div>
            </div>

            <!-- reCAPTCHA -->
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
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

            <!-- Link para Cadastro -->
            <div class="text-center">
                <small>Ainda não tem uma conta? <a href="{{ route('register2') }}" class="text-decoration-none">Cadastre-se</a></small>
            </div>
        </form>
    </div>
</div>

<!-- Script do reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Validação do reCAPTCHA antes de enviar o formulário -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $('form').submit(function(e){
      if(grecaptcha.getResponse() === ''){
        e.preventDefault();
        alert('Por favor, confirme o reCAPTCHA.');
      }
    });
  });
</script>
@endsection