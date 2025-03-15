@extends('layouts.painel-admin')
@section('header_title', 'Editar API KEY ASAAS')
@section('content')
    <div class="container mt-5, ms-2">
        <form action="#" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="api_key_asaas" class="form-label">API KEY ASAAS</label>
                <input type="text" name="api_key_asaas" class="form-control" id="api_key_asaas" value="{{ old('api_key_asaas', $apiKeyAsaas) }}" required/>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="#" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
