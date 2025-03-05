@extends('layouts.appusuarioautentificado')

@push('styles')
<style>
    .container {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
    }
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }
    .table-custom th, .table-custom td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    .table-custom th {
        background-color: #f8f9fa;
    }
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        padding: 4px 8px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
    }
    .btn-whatsapp:hover {
        background-color: #128C7E;
    }
</style>
@endpush

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Meus Agendamentos</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-custom">
        <thead>
            <tr>
                <th>Médico</th>
                <th>Clínica</th>
                <th>Procedimento</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Preço</th>
                <th>Status</th>
                <th>SAC</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendamentos as $agendamento)
                <tr>
                    <td>{{ $agendamento->medico_nome ?? '--' }}</td>
                    <td>{{ $agendamento->clinica_nome ?? '--' }}</td>
                    <td>{{ $agendamento->procedimento_nome ?? '--' }}</td>
                    <td>{{ $agendamento->data ? \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') : '--' }}</td>
                    <td>{{ $agendamento->horario_inicio ?? '--' }}</td>
                    <td>
                        R$ {{ number_format($agendamento->horario->procedimento->valor ?? 0, 2, ',', '.') }}
                    </td>
                    <td>{{ $agendamento->status }}</td>
                    <td class="text-end">
                        <a href="https://api.whatsapp.com/send?phone=554188322656&text=Olá, tenho uma dúvida sobre meu agendamento" 
                           target="_blank" class="btn-whatsapp">
                            WhatsApp
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Nenhum agendamento disponível.</span>
                            <a href="https://api.whatsapp.com/send?phone=554188322656&text=Olá, tenho uma dúvida sobre meu agendamento" 
                               target="_blank" class="btn-whatsapp">
                                WhatsApp
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
