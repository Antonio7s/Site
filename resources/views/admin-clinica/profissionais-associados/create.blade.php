@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <div id="profissionais-associados">
        <h3>Profissionais Associados</h3>
        <form id="formProfissional">
            <div class="mb-3">
                <label for="employeeName" class="form-label">Nome do Profissional</label>
                <input type="text" id="employeeName" class="form-control" placeholder="Nome do profissional" required>
            </div>
            <div class="mb-3">
                <label for="employeeSpecialties" class="form-label">Especialidades</label>
                <!-- Select para múltiplos itens -->
                <select id="especialidades" class="form-control" name="especialidades[]" multiple required>
                    forelse()
                        <option value="especialidade1">Especialidade 1</option>
                        @empty
                        <tr>
                            <td colspan="5">Nenhuma clínica encontrada.</td>
                        </tr>
                    @endforelse
                </select>
            </div>
            <div class="mb-3">
                <!-- Select para múltiplos itens -->
                <label for="" class="form-label">Procedimentos</label>
                <select id="procedimentos" class="form-control" name="procedimentos[]" multiple required>
                    for    
                        <option value="procedimento1">Procedimento 1</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="employeeEmail" class="form-label">E-mail</label>
                <input type="email" id="employeeEmail" class="form-control" placeholder="E-mail do profissional" required>
            </div>
            <div class="mb-3">
                <label for="employeePhone" class="form-label">Telefone</label>
                <input type="tel" id="employeePhone" class="form-control" placeholder="Telefone do profissional" required>
            </div>
            <div class="mb-3">
                <label for="employeePhoto" class="form-label">Foto</label>
                <input type="file" id="employeePhoto" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="employeeCouncil" class="form-label">Registro do Conselho</label>
                <select id="employeeCouncil" class="form-select" required>
                    <option value="">Selecione o Conselho</option>
                    <option value="CRM">CRM</option>
                    <option value="CRO">CRO</option>
                    <option value="CRP">CRP</option>
                    <option value="CRN">CRN</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="employeeCouncilNumber" class="form-label">Número do Conselho/UF</label>
                <input type="text" id="employeeCouncilNumber" class="form-control" placeholder="Número do Conselho/UF" required>
            </div>
            <div class="mb-3">
                <label for="employeeReturnConsultation" class="form-label">Consulta de Retorno</label>
                <select id="employeeReturnConsultation" class="form-select" required onchange="toggleReturnDays()">
                    <option value="">Selecione</option>
                    <option value="sim">Sim</option>
                    <option value="nao">Não</option>
                </select>
            </div>
            <div class="mb-3" id="returnDaysField" style="display: none;">
                <label for="employeeReturnDays" class="form-label">Dias para Retorno</label>
                <input type="number" id="employeeReturnDays" class="form-control" placeholder="Informe os dias para retorno">
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
