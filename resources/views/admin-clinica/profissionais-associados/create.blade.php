@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <div id="profissionais-associados">
        <h3>Profissionais Associados</h3>
        
        <!-- Exibição de erros de validação -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formProfissional" action="{{ route('admin-clinica.profissionais-associados.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="clinica_id" id="clinica_id" value="{{ Auth::guard('clinic')->user()->id }}"></input>

            <div class="mb-3">
                <label for="employeeName" class="form-label">Nome do Profissional</label>
                <input type="text" id="employeeName" name="primeiro_nome" class="form-control" placeholder="Nome do profissional" value="{{ old('primeiro_nome') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="employeeSpecialties" class="form-label">Especialidades</label>
                <!-- Select para múltiplos itens -->
                <select id="especialidades" class="form-control" name="especialidades[]" multiple required>
                    @forelse($especialidades as $especialidade)
                        <option value="{{ $especialidade->id }}" {{ (collect(old('especialidades'))->contains($especialidade->id)) ? 'selected' : '' }}>{{ $especialidade->nome }}</option>
                    @empty
                        <option disabled>Nenhuma especialidade encontrada.</option>
                    @endforelse
                </select>
            </div>
            
            <div class="mb-3">
                <label for="procedimentos" class="form-label">Procedimentos</label>
                <select id="procedimentos" class="form-control" name="procedimentos[]" multiple required>
                    @forelse($procedimentos as $procedimento)
                        <option value="{{ $procedimento->id }}" {{ (collect(old('procedimentos'))->contains($procedimento->id)) ? 'selected' : '' }}>{{ $procedimento->nome }}</option>
                    @empty
                        <option disabled>Nenhum procedimento encontrado.</option>
                    @endforelse
                </select>
            </div>

            <div class="mb-3">
                <label for="employeeEmail" class="form-label">E-mail</label>
                <input type="email" id="employeeEmail" name="email" class="form-control" placeholder="E-mail do profissional" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="employeePhone" class="form-label">Telefone</label>
                <input type="tel" id="employeePhone" name="telefone" class="form-control" placeholder="Telefone do profissional" value="{{ old('telefone') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="foto_url" class="form-label">Foto</label>
                <input type="file" id="foto_url" name="foto_url" class="form-control" accept="image/*">
            </div>
            
            <div class="mb-3">
                <label for="employeeCouncil" class="form-label">Registro do Conselho</label>
                <select id="employeeCouncil" class="form-select" name="conselho" required>
                    <option value="">Selecione o Conselho</option>
                    <option value="CRM" {{ old('conselho') == 'CRM' ? 'selected' : '' }}>CRM</option>
                    <option value="CRO" {{ old('conselho') == 'CRO' ? 'selected' : '' }}>CRO</option>
                    <option value="CRP" {{ old('conselho') == 'CRP' ? 'selected' : '' }}>CRP</option>
                    <option value="CRN" {{ old('conselho') == 'CRN' ? 'selected' : '' }}>CRN</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="employeeCouncilNumber" class="form-label">Número do Conselho/UF</label>
                <input type="text" id="employeeCouncilNumber" name="crm" class="form-control" placeholder="Número do Conselho/UF" value="{{ old('crm') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="employeeReturnConsultation" class="form-label">Consulta de Retorno</label>
                <select id="employeeReturnConsultation" class="form-select" name="consulta_retorno" required onchange="toggleReturnDays()">
                    <option value="">Selecione</option>
                    <option value="sim" {{ old('consulta_retorno') == 'sim' ? 'selected' : '' }}>Sim</option>
                    <option value="nao" {{ old('consulta_retorno') == 'nao' ? 'selected' : '' }}>Não</option>
                </select>
            </div>
            
            <div class="mb-3" id="returnDaysField" style="display: {{ old('consulta_retorno') == 'sim' ? 'block' : 'none' }};">
                <label for="employeeReturnDays" class="form-label">Dias para Retorno</label>
                <input type="number" id="employeeReturnDays" name="dias_retorno" class="form-control" placeholder="Informe os dias para retorno" value="{{ old('dias_retorno') }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Adicionar Profissional</button>
        </form>
    </div>

    <script>
        function toggleReturnDays() {
            let select = document.getElementById("employeeReturnConsultation");
            let returnField = document.getElementById("returnDaysField");
            returnField.style.display = select.value === "sim" ? "block" : "none";
        }
    </script>

@endsection
