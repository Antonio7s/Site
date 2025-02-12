@extends('layouts.painel-admin')
@section('header_title', 'Serviços diferenciados') 
@section('content')

    <div class="container mt-5 ms-2">        
        <!-- Formulário de Cadastro -->
        <form>

            <div class="mb-3">
                <label for="clinica" class="form-label">Clínica vinculada</label>
                <select class="form-select" id="clinica" required>
                    <option value="" selected disabled>Selecione uma clínica</option>
                    @forelse($clinicas as $clinica)
                        <option value="clinica_a">{{ $clinica->nome_fantasia ?? 'Não informado' }}</option>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma clínica encontrada.</td>
                        </tr>
                    @endforelse
                </select>
            </div>
            
            <div class="mb-3">
                <label for="dataInicial" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="dataInicial" required>
            </div>
            <div class="mb-3">
                <label for="dataFinal" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="dataFinal">
            </div>

            <div class="mb-3">
                <label for="procedimento" class="form-label">Procedimento</label>
                <select class="form-select" id="procedimento" id="procedimento" required>
                    <option value="" selected disabled>Selecione um procedimento</option>
                    @forelse($procedimentos as $procedimento)
                    <option value="clinica_a">{{ $procedimento->nome ?? 'Não informado' }}</option>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma clínica encontrada.</td>
                        </tr>
                    @endforelse
                </select>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" class="form-control" id="valor" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
@endsection