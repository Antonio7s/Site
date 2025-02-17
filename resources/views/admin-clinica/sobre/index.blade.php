@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')
    <!-- Sobre a Clínica -->
    <div>
        <h3>Sobre a Clínica</h3>
        <form>
            <div class="mb-3">
                <label for="clinicName" class="form-label">Nome da Clínica</label>
                <input type="text" id="clinicName" class="form-control" placeholder="Digite o nome da clínica" required>
            </div>
            <div class="mb-3">
                <label for="clinicDescription" class="form-label">Descrição</label>
                <textarea id="clinicDescription" class="form-control" rows="4" placeholder="Descreva um pouco sobre a clínica" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Descrição</button>
        </form>

        <!-- Localização -->
        <div id="localizacao">
            <h3>Localização</h3>
            <form>
                <div class="mb-3">
                    <label for="address" class="form-label">Endereço</label>
                    <input type="text" id="address" class="form-control" placeholder="Digite o endereço da clínica" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">Cidade</label>
                    <input type="text" id="city" class="form-control" placeholder="Digite a cidade" required>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label">Estado</label>
                    <input type="text" id="state" class="form-control" placeholder="Digite o estado" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar Localização</button>
            </form>
        </div>

    </div>

@endsection