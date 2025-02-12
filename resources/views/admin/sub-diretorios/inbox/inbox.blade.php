@extends('layouts.painel-admin')
@section('header_title', 'Menssagens') <!-- Alterando o h1 -->
@section('content')
    <div class="form-section">
            <h3>Caixa de Entrada</h3>
            <!-- Lista de E-mails -->
            <ul class="list-group" id="emailList">
                <!-- Exemplo de E-mail 1 -->
                <li class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#emailModal" onclick="viewEmail(1)">
                    <div>
                        <strong>Assunto do E-mail 1</strong> - remetente@exemplo.com
                        <div class="text-muted">Prévia do conteúdo do e-mail...</div>
                    </div>
                    <span class="badge bg-primary rounded-pill">Novo</span>
                    <div class="email-options">
                        <button class="btn btn-link btn-sm" onclick="markAsRead(1)">
                            <i class="bi bi-check-circle"></i> Marcar como Lido
                        </button>
                        <button class="btn btn-link btn-sm" onclick="deleteEmail(1)">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </div>
                </li>
                <!-- Exemplo de E-mail 2 -->
                <li class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#emailModal" onclick="viewEmail(2)">
                    <div>
                        <strong>Assunto do E-mail 2</strong> - outroremetente@exemplo.com
                        <div class="text-muted">Prévia do conteúdo do e-mail 2...</div>
                    </div>
                    <span class="badge bg-secondary rounded-pill">Lido</span>
                    <div class="email-options">
                        <button class="btn btn-link btn-sm" onclick="markAsRead(2)">
                            <i class="bi bi-check-circle"></i> Marcar como Lido
                        </button>
                        <button class="btn btn-link btn-sm" onclick="deleteEmail(2)">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </div>
                </li>
                <!-- Exemplo de E-mail 3 -->
                <li class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#emailModal" onclick="viewEmail(3)">
                    <div>
                        <strong>Assunto do E-mail 3</strong> - maisremetente@exemplo.com
                        <div class="text-muted">Prévia do conteúdo do e-mail 3...</div>
                    </div>
                    <span class="badge bg-primary rounded-pill">Novo</span>
                    <div class="email-options">
                        <button class="btn btn-link btn-sm" onclick="markAsRead(3)">
                            <i class="bi bi-check-circle"></i> Marcar como Lido
                        </button>
                        <button class="btn btn-link btn-sm" onclick="deleteEmail(3)">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </div>
                </li>
                <!-- Exemplo de E-mail 4 -->
                <li class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#emailModal" onclick="viewEmail(4)">
                    <div>
                        <strong>Assunto do E-mail 4</strong> - exemplo4@dominio.com
                        <div class="text-muted">Prévia do conteúdo do e-mail 4...</div>
                    </div>
                    <span class="badge bg-primary rounded-pill">Novo</span>
                    <div class="email-options">
                        <button class="btn btn-link btn-sm" onclick="markAsRead(4)">
                            <i class="bi bi-check-circle"></i> Marcar como Lido
                        </button>
                        <button class="btn btn-link btn-sm" onclick="deleteEmail(4)">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
