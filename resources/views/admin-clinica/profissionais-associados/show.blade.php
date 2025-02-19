@extends('layouts.painel-clinica')
@section('header_title', 'Visualização do Profissional')
@section('content')

<div class="container">
    <h3 class="mb-4">Visualização do Profissional</h3>
    
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $profissional->profissional_nome }} {{ $profissional->profissional_sobrenome }}</h4>
            
            <p><strong>E-mail:</strong> {{ $profissional->email }}</p>
            <p><strong>Telefone:</strong> {{ $profissional->telefone }}</p>

            <p>
                <strong>Especialidades:</strong>
                @if($profissional->especialidades && $profissional->especialidades->count())
                    @foreach($profissional->especialidades as $especialidade)
                        {{ $especialidade->nome }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                @else
                    Nenhuma especialidade cadastrada.
                @endif
            </p>

            <p>
                <strong>Procedimentos:</strong>
                @if($profissional->procedimentos && $profissional->procedimentos->count())
                    @foreach($profissional->procedimentos as $procedimento)
                        {{ $procedimento->nome }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                @else
                    Nenhum procedimento cadastrado.
                @endif
            </p>

            <p><strong>Conselho:</strong> {{ $profissional->conselho_nome }}</p>
            <p><strong>Número do Conselho/UF:</strong> {{ $profissional->crm }}</p>
            <p>
                <strong>Consulta de Retorno:</strong> 
                {{ $profissional->consulta_retorno == 'sim' ? 'Sim' : 'Não' }}
            </p>
            @if($profissional->consulta_retorno == 'sim')
                <p><strong>Dias para Retorno:</strong> {{ $profissional->dias_retorno }}</p>
            @endif

            @if($profissional->foto_url)
                <div class="mb-3">
                    <strong>Foto:</strong><br>
                    <img src="{{ asset('storage/' . $profissional->foto_url) }}" alt="Foto do Profissional" class="img-thumbnail" style="max-width:200px;">
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin-clinica.profissionais-associados.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

@endsection
