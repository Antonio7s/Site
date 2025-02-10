@extends('layouts.layout-index')

@section('content')
<div class="card mx-auto mt-5 shadow" style="max-width: 500px; border: none;">
    <div class="card-header text-center" style="background: #fff; border-bottom: 1px solid #dee2e6;">
         <h4 style="color: #007bff; font-weight: bold;">Cadastro de Clínica</h4>
    </div>
    <div class="card-body">
         <form method="POST" action="{{ route('register2') }}">
             @csrf

             <!-- Razão Social -->
             <div class="mb-3">
                 <x-input-label for="razao_social" :value="__('Razão Social')" />
                 <x-text-input id="razao_social" class="form-control" type="text" name="razao_social" :value="old('razao_social')" required autofocus autocomplete="name" />
                 <x-input-error :messages="$errors->get('razao_social')" class="mt-2" />
             </div>

             <!-- Nome Fantasia -->
             <div class="mb-3">
                 <x-input-label for="nome_fantasia" :value="__('Nome Fantasia')" />
                 <x-text-input id="nome_fantasia" class="form-control" type="text" name="nome_fantasia" :value="old('nome_fantasia')" required autocomplete="nome_fantasia" />
                 <x-input-error :messages="$errors->get('nome_fantasia')" class="mt-2" />
             </div>

             <!-- CNPJ/CPF -->
             <div class="mb-3">
                 <x-input-label for="cnpj_cpf" :value="__('CNPJ/CPF')" />
                 <x-text-input id="cnpj_cpf" class="form-control" type="text" name="cnpj_cpf" :value="old('cnpj_cpf')" required autocomplete="cnpj_cpf" />
                 <x-input-error :messages="$errors->get('cnpj_cpf')" class="mt-2" />
             </div>

             <!-- Email -->
             <div class="mb-3">
                 <x-input-label for="email" :value="__('Email')" />
                 <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                 <x-input-error :messages="$errors->get('email')" class="mt-2" />
             </div>

             <!-- Password -->
             <div class="mb-3">
                 <x-input-label for="password" :value="__('Password')" />
                 <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                 <x-input-error :messages="$errors->get('password')" class="mt-2" />
             </div>

             <!-- Confirm Password -->
             <div class="mb-3">
                 <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                 <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                 <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
             </div>

             <div class="d-flex justify-content-between align-items-center">
                 <a class="text-decoration-none" href="{{ route('login2') }}">
                     {{ __('Já possui cadastro?') }}
                 </a>
                 <x-primary-button class="btn btn-primary">
                     {{ __('Cadastro') }}
                 </x-primary-button>
             </div>
         </form>
    </div>
</div>
@endsection


