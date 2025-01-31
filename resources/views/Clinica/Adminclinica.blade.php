@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Adm Clínica</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #003366;
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: start;
            padding: 10px;
        }
        .sidebar h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: white;
            font-size: 1rem;
            padding: 10px;
            text-decoration: none;
            width: 100%;
            text-align: left;
        }
        .sidebar .nav-link:hover {
            background-color: #004080;
            border-radius: 5px;
        }
        .header {
            background-color: #003366;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            width: calc(100% - 250px);
            left: 250px;
            top: 0;
            z-index: 1000;
        }
        .header .user-info {
            display: flex;
            align-items: center;
        }
        .header .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .content {
            margin-top: 60px;
            margin-left: 250px;
            padding: 20px;
        }
        .tab-content .form-label {
            font-weight: bold;
        }

        /* Ajustes nas abas */
        .nav-link.active {
            background-color: #004080;
        }

        /* Ajustes para o formulário de Funcionários */
        .form-select {
            width: 100%;
            border-radius: 5px;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .photo-input {
            display: block;
            margin-top: 10px;
        }

        /* Estilo para a aba de especialidades */
        .specialty-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1050;
        }
        .specialty-modal.show {
            display: block;
        }
        .specialty-modal .modal-content {
            max-height: 300px;
            overflow-y: auto;
        }
        .specialty-modal .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .specialty-modal .modal-footer button {
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Painel Adm Clínica</h1>
        <div class="nav flex-column" role="tablist">
            <a href="#servicos" class="nav-link" data-bs-toggle="tab" role="tab">Serviços</a>
            <a href="#sobre-clinica" class="nav-link" data-bs-toggle="tab" role="tab">Sobre a Clínica</a>
            <a href="#localizacao" class="nav-link" data-bs-toggle="tab" role="tab">Localização</a>
            <a href="#funcionarios" class="nav-link active" data-bs-toggle="tab" role="tab">Funcionários</a>
            <a href="#lista-funcionarios" class="nav-link" data-bs-toggle="tab" role="tab">Lista de Funcionários</a>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <span>Bem-vindo ao Painel</span>
        <div class="user-info">
            <img src="{{ asset('images/icone-usuario.png') }}" alt="Foto da Clínica">
            <span>Clínica Logada</span>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="tab-content">

            <!-- Serviços -->
            <div id="servicos" class="tab-pane fade" role="tabpanel">
                <h3>Serviços</h3>
                <form>
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Nome do Serviço</label>
                        <input type="text" id="serviceName" class="form-control" placeholder="Digite o nome do serviço" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceDescription" class="form-label">Descrição do Serviço</label>
                        <textarea id="serviceDescription" class="form-control" rows="4" placeholder="Descreva o serviço" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Serviço</button>
                </form>
            </div>

            <!-- Sobre a Clínica -->
            <div id="sobre-clinica" class="tab-pane fade" role="tabpanel">
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
            </div>

            <!-- Localização -->
            <div id="localizacao" class="tab-pane fade" role="tabpanel">
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

            <!-- Funcionários -->
            <div id="funcionarios" class="tab-pane fade show active" role="tabpanel">
                <h3>Adicionar Funcionário</h3>
                <form>
                    <div class="mb-3">
                        <label for="employeeName" class="form-label">Nome do Funcionário</label>
                        <input type="text" id="employeeName" class="form-control" placeholder="Nome do funcionário" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeRole" class="form-label">Função</label>
                        <input type="text" id="employeeRole" class="form-control" placeholder="Função do funcionário" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeEmail" class="form-label">E-mail</label>
                        <input type="email" id="employeeEmail" class="form-control" placeholder="E-mail do funcionário" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeePhone" class="form-label">Telefone</label>
                        <input type="tel" id="employeePhone" class="form-control" placeholder="Telefone do funcionário" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeePhoto" class="form-label">Foto</label>
                        <input type="file" id="employeePhoto" class="form-control photo-input" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="employeeCRM" class="form-label">CRM</label>
                        <input type="text" id="employeeCRM" class="form-control" placeholder="CRM do funcionário" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeSpecialties" class="form-label">Especialidades</label>
                        <button type="button" class="btn btn-secondary" onclick="openSpecialtyModal()">Escolher Especialidades</button>
                        <div id="selectedSpecialties" class="mt-2"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Funcionário</button>
                </form>
            </div>

            <!-- Lista de Funcionários -->
            <div id="lista-funcionarios" class="tab-pane fade" role="tabpanel">
                <h3>Lista de Funcionários</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Função</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Foto</th>
                            <th>CRM</th>
                            <th>Especialidades</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>João Silva</td>
                            <td>Médico</td>
                            <td>joao@clinica.com</td>
                            <td>(31) 99999-9999</td>
                            <td><img src="{{ asset('images/joao.jpg') }}" alt="João" width="50"></td>
                            <td>12345</td>
                            <td>Cardiologia, Dermatologia</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Editar</button>
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ana Souza</td>
                            <td>Enfermeira</td>
                            <td>ana@clinica.com</td>
                            <td>(31) 98888-8888</td>
                            <td><img src="{{ asset('images/ana.jpg') }}" alt="Ana" width="50"></td>
                            <td>54321</td>
                            <td>Endocrinologia, Ginecologia</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Editar</button>
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal de Especialidades -->
    <div id="specialtyModal" class="specialty-modal">
        <div class="modal-content">
            <h4>Escolha as Especialidades</h4>
            <div id="specialtyList">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Alergia e imunologia" id="specialty1">
                    <label class="form-check-label" for="specialty1">Alergia e imunologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Anestesiologia" id="specialty2">
                    <label class="form-check-label" for="specialty2">Anestesiologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Angiologia" id="specialty3">
                    <label class="form-check-label" for="specialty3">Angiologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cardiologia" id="specialty4">
                    <label class="form-check-label" for="specialty4">Cardiologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia cardiovascular" id="specialty5">
                    <label class="form-check-label" for="specialty5">Cirurgia cardiovascular</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia da mão" id="specialty6">
                    <label class="form-check-label" for="specialty6">Cirurgia da mão</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia de cabeça e pescoço" id="specialty7">
                    <label class="form-check-label" for="specialty7">Cirurgia de cabeça e pescoço</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia do aparelho digestivo" id="specialty8">
                    <label class="form-check-label" for="specialty8">Cirurgia do aparelho digestivo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia geral" id="specialty9">
                    <label class="form-check-label" for="specialty9">Cirurgia geral</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia oncológica" id="specialty10">
                    <label class="form-check-label" for="specialty10">Cirurgia oncológica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia pediátrica" id="specialty11">
                    <label class="form-check-label" for="specialty11">Cirurgia pediátrica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia plástica" id="specialty12">
                    <label class="form-check-label" for="specialty12">Cirurgia plástica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia torácica" id="specialty13">
                    <label class="form-check-label" for="specialty13">Cirurgia torácica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Cirurgia vascular" id="specialty14">
                    <label class="form-check-label" for="specialty14">Cirurgia vascular</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Clínica médica" id="specialty15">
                    <label class="form-check-label" for="specialty15">Clínica médica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Coloproctologia" id="specialty16">
                    <label class="form-check-label" for="specialty16">Coloproctologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Dermatologia" id="specialty17">
                    <label class="form-check-label" for="specialty17">Dermatologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Endocrinologia e metabologia" id="specialty18">
                    <label class="form-check-label" for="specialty18">Endocrinologia e metabologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Endoscopia" id="specialty19">
                    <label class="form-check-label" for="specialty19">Endoscopia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Gastroenterologia" id="specialty20">
                    <label class="form-check-label" for="specialty20">Gastroenterologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Genética médica" id="specialty21">
                    <label class="form-check-label" for="specialty21">Genética médica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Geriatria" id="specialty22">
                    <label class="form-check-label" for="specialty22">Geriatria</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Ginecologia e obstetrícia" id="specialty23">
                    <label class="form-check-label" for="specialty23">Ginecologia e obstetrícia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Hematologia e hemoterapia" id="specialty24">
                    <label class="form-check-label" for="specialty24">Hematologia e hemoterapia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Homeopatia" id="specialty25">
                    <label class="form-check-label" for="specialty25">Homeopatia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Infectologia" id="specialty26">
                    <label class="form-check-label" for="specialty26">Infectologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Mastologia" id="specialty27">
                    <label class="form-check-label" for="specialty27">Mastologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina de emergência" id="specialty28">
                    <label class="form-check-label" for="specialty28">Medicina de emergência</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina de família e comunidade" id="specialty29">
                    <label class="form-check-label" for="specialty29">Medicina de família e comunidade</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina do trabalho" id="specialty30">
                    <label class="form-check-label" for="specialty30">Medicina do trabalho</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina do tráfego" id="specialty31">
                    <label class="form-check-label" for="specialty31">Medicina do tráfego</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina esportiva" id="specialty32">
                    <label class="form-check-label" for="specialty32">Medicina esportiva</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina física e reabilitação" id="specialty33">
                    <label class="form-check-label" for="specialty33">Medicina física e reabilitação</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina intensiva" id="specialty34">
                    <label class="form-check-label" for="specialty34">Medicina intensiva</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina legal e perícia médica" id="specialty35">
                    <label class="form-check-label" for="specialty35">Medicina legal e perícia médica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Medicina preventiva e social" id="specialty36">
                    <label class="form-check-label" for="specialty36">Medicina preventiva e social</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Nefrologia" id="specialty37">
                    <label class="form-check-label" for="specialty37">Nefrologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Neurocirurgia" id="specialty38">
                    <label class="form-check-label" for="specialty38">Neurocirurgia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Neurologia" id="specialty39">
                    <label class="form-check-label" for="specialty39">Neurologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Nutrologia" id="specialty40">
                    <label class="form-check-label" for="specialty40">Nutrologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Oftalmologia" id="specialty41">
                    <label class="form-check-label" for="specialty41">Oftalmologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Oncologia clínica" id="specialty42">
                    <label class="form-check-label" for="specialty42">Oncologia clínica</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Ortopedia e traumatologia" id="specialty43">
                    <label class="form-check-label" for="specialty43">Ortopedia e traumatologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Otorrinolaringologia" id="specialty44">
                    <label class="form-check-label" for="specialty44">Otorrinolaringologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Patologia" id="specialty45">
                    <label class="form-check-label" for="specialty45">Patologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Patologia clínica/medicina laboratorial" id="specialty46">
                    <label class="form-check-label" for="specialty46">Patologia clínica/medicina laboratorial</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Pediatria" id="specialty47">
                    <label class="form-check-label" for="specialty47">Pediatria</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Pneumologia" id="specialty48">
                    <label class="form-check-label" for="specialty48">Pneumologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Psiquiatria" id="specialty49">
                    <label class="form-check-label" for="specialty49">Psiquiatria</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Radiologia e diagnóstico por imagem" id="specialty50">
                    <label class="form-check-label" for="specialty50">Radiologia e diagnóstico por imagem</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Radioterapia" id="specialty51">
                    <label class="form-check-label" for="specialty51">Radioterapia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Reumatologia" id="specialty52">
                    <label class="form-check-label" for="specialty52">Reumatologia</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Urologia" id="specialty53">
                    <label class="form-check-label" for="specialty53">Urologia</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeSpecialtyModal()">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="saveSpecialties()">Salvar</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para abrir o modal de especialidades
        function openSpecialtyModal() {
            document.getElementById('specialtyModal').classList.add('show');
        }

        // Função para fechar o modal de especialidades
        function closeSpecialtyModal() {
            document.getElementById('specialtyModal').classList.remove('show');
        }

        // Função para salvar as especialidades selecionadas
        function saveSpecialties() {
            const selectedSpecialties = [];
            const checkboxes = document.querySelectorAll('#specialtyList input[type="checkbox"]:checked');
            checkboxes.forEach(checkbox => {
                selectedSpecialties.push(checkbox.value);
            });
            document.getElementById('selectedSpecialties').innerText = selectedSpecialties.join(', ');
            closeSpecialtyModal();
        }
    </script>
</body>
</html>
@endsection
