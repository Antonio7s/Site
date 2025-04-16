@extends('layouts.appusuarioautentificado')

@push('styles')
<style>
    /* Container geral */
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    h2 {
        font-size: 24px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Tabela customizada */
    .table-custom th, .table-custom td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    .table-custom th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }

    .btn-whatsapp:hover {
        background-color: #128C7E;
    }

    /* Painel lateral */
    .side-panel {
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        background-color: #fff;
        transition: 0.3s;
        z-index: 1000;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
    }

    .side-panel.open {
        left: 0;
    }

    .side-panel .panel-content {
        padding: 20px;
    }

    .side-panel .panel-title {
        font-size: 22px;
        margin-top: 30px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #007bff;
    }

    .side-panel a {
        display: block;
        padding: 10px;
        color: #007bff;
        text-decoration: none;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .side-panel a:hover {
        background-color: #f0f0f0;
    }

    /* Botão de menu */
    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 16px;
        color: white;
        cursor: pointer;
        z-index: 1100;
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .toggle-btn:hover {
        background-color: #0056b3;
    }

    .toggle-btn:focus {
        outline: none;
    }

    /* Botão Sair */
    .side-panel .btn-link {
        color: red !important;
        text-decoration: none;
        padding: 10px;
        margin-top: 10px;
        display: block;
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
    }

    .side-panel .btn-link:hover {
        background-color: #f0f0f0;
    }

    /* Media Queries para responsividade */
    @media (max-width: 1200px) {
        .container { padding: 15px; }
        h2 { font-size: 22px; }
        .table-custom th, .table-custom td { padding: 10px; font-size: 14px; }
        .btn-whatsapp { font-size: 12px; padding: 5px 10px; }
    }

    @media (max-width: 992px) {
        .container { padding: 10px; }
        h2 { font-size: 20px; }
        .table-custom th, .table-custom td { padding: 8px; font-size: 13px; }
        .btn-whatsapp { font-size: 11px; padding: 4px 8px; }
        .side-panel { width: 220px; }
        .side-panel .panel-title { font-size: 20px; }
        .side-panel a { font-size: 14px; }
        .toggle-btn { font-size: 14px; padding: 6px 10px; }
    }

    @media (max-width: 768px) {
        h2 { font-size: 18px; }
        .table-custom th, .table-custom td { padding: 6px; font-size: 12px; }
        .btn-whatsapp { font-size: 10px; padding: 3px 6px; }
        .side-panel { width: 200px; }
        .side-panel .panel-title { font-size: 18px; }
        .side-panel a { font-size: 13px; }
        .toggle-btn { font-size: 12px; padding: 5px 8px; }
    }

    @media (max-width: 576px) {
        h2 { font-size: 16px; }
        .table-custom th, .table-custom td { padding: 4px; font-size: 11px; }
        .btn-whatsapp { font-size: 9px; padding: 2px 4px; }
        .side-panel { width: 180px; }
        .side-panel .panel-title { font-size: 16px; }
        .side-panel a { font-size: 12px; }
        .toggle-btn { font-size: 10px; padding: 4px 6px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <h2>Meus Agendamentos</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>Voucher</th>
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
                        <td>
                            @if(strtolower($agendamento->status) === 'agendado')
                                {{ $agendamento->voucher ?? '--' }}
                            @else
                                --
                            @endif
                        </td>
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
                        <td colspan="9">
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
</div>

<button class="toggle-btn" onclick="togglePanel()">&#9776; Menu</button>

<div class="side-panel" id="sidePanel">
    <div class="panel-content">
        <div class="panel-title">Painel</div>
        <a href="{{ url('/') }}">Página Inicial</a>
        <a href="{{ route('perfil.minhasInformacoes') }}">Minhas Informações</a>
        <a href="{{ url('perfil/meus-pedidos') }}">Meus Pedidos</a>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link">Sair</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePanel() {
        const panel = document.getElementById('sidePanel');
        panel.classList.toggle('open');
    }
</script>
@endpush
