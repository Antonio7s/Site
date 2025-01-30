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
        .employee-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .employee-status {
            margin-right: 10px;
        }
        .employee-remove {
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h1>Painel Adm Clínica</h1>
        <div class="nav flex-column" role="tablist">
            <a href="#servicos" class="nav-link active" data-bs-toggle="tab" role="tab">Serviços</a>
            <a href="#sobre-clinica" class="nav-link" data-bs-toggle="tab" role="tab">Sobre a Clínica</a>
            <a href="#localizacao" class="nav-link" data-bs-toggle="tab" role="tab">Localização</a>
            <a href="#funcionarios" class="nav-link" data-bs-toggle="tab" role="tab">Funcionários</a>
            <a href="#dados-cadastrais" class="nav-link" data-bs-toggle="tab" role="tab">Dados Cadastrais</a>
            <a href="#banner" class="nav-link" data-bs-toggle="tab" role="tab">Banner</a>
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
            <div id="servicos" class="tab-pane fade show active" role="tabpanel">
                <h3>Serviços</h3>
                <form>
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Nome do Serviço</label>
                        <input type="text" id="serviceName" class="form-control" placeholder="Ex.: Consulta, Exame" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceCategory" class="form-label">Categoria</label>
                        <select id="serviceCategory" class="form-select" required>
                            <option value="" disabled selected>Selecione uma categoria</option>
                            <option value="Consulta">Consulta</option>
                            <option value="Exame">Exame</option>
                            <option value="Vacinas">Vacinas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="servicePrice" class="form-label">Preço (R$)</label>
                        <input type="number" id="servicePrice" class="form-control" placeholder="Ex.: 50.00" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Serviço</button>
                </form>
            </div>

            <!-- Sobre a Clínica -->
            <div id="sobre-clinica" class="tab-pane fade" role="tabpanel">
                <h3>Sobre a Clínica</h3>
                <form>
                    <div class="mb-3">
                        <label for="aboutClinic" class="form-label">Descrição</label>
                        <textarea id="aboutClinic" class="form-control" rows="6" placeholder="Escreva as informações da clínica"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Informações</button>
                </form>
            </div>

            <!-- Localização -->
            <div id="localizacao" class="tab-pane fade" role="tabpanel">
                <h3>Localização</h3>
                <form>
                    <div class="mb-3">
                        <label for="city" class="form-label">Cidade</label>
                        <input type="text" id="city" class="form-control" placeholder="Digite a cidade" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">Estado</label>
                        <select id="state" class="form-select" required>
                            <option value="" disabled selected>Selecione um estado</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AM">Amazonas</option>
                            <option value="AP">Amapá</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="PR">Paraná</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SE">Sergipe</option>
                            <option value="SP">São Paulo</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Localização</button>
                </form>
            </div>

            <!-- Funcionários -->
            <div id="funcionarios" class="tab-pane fade" role="tabpanel">
                <h3>Funcionários</h3>
                <form>
                    <div class="mb-3">
                        <label for="employeePhoto" class="form-label">Foto do Funcionário</label>
                        <input type="file" id="employeePhoto" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeCRM" class="form-label">Registro (CRM)</label>
                        <input type="text" id="employeeCRM" class="form-control" placeholder="Digite o CRM do Funcionário" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeeAbout" class="form-label">Sobre Mim</label>
                        <textarea id="employeeAbout" class="form-control" placeholder="Escreva sobre o funcionário"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="employeeEducation" class="form-label">Formação e Experiência</label>
                        <textarea id="employeeEducation" class="form-control" placeholder="Detalhe a formação e experiência do funcionário"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="employeeConditions" class="form-label">Doenças, Sintomas ou Condições</label>
                        <textarea id="employeeConditions" class="form-control" placeholder="Descreva doenças, sintomas ou condições tratadas"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Funcionário</button>
                </form>
            </div>

            <!-- Dados Cadastrais -->
            <div id="dados-cadastrais" class="tab-pane fade" role="tabpanel">
                <h3>Dados Cadastrais</h3>
                <p>Insira os dados cadastrais da pessoa aqui.</p>
            </div>

            <!-- Banner -->
            <div id="banner" class="tab-pane fade" role="tabpanel">
                <h3>Banner</h3>
                <form>
                    <div class="mb-3">
                        <label for="bannerUpload" class="form-label">Carregar Banner</label>
                        <input type="file" id="bannerUpload" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Banner</button>
                </form>
            </div>

            <!-- Lista de Funcionários -->
            <div id="lista-funcionarios" class="tab-pane fade" role="tabpanel">
                <h3>Lista de Funcionários</h3>
                <div id="employeeList">
                    <!-- Funcionários adicionados estarão aqui -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        const employeeList = document.getElementById('employeeList');

        // Adicionar funcionário
        function addEmployee(name, status = 'Ativo') {
            const employeeItem = document.createElement('div');
            employeeItem.className = 'employee-item';

            const employeeName = document.createElement('span');
            employeeName.textContent = name;

            const employeeStatus = document.createElement('select');
            employeeStatus.className = 'employee-status form-select form-select-sm';
            employeeStatus.innerHTML = `
                <option value="Ativo" ${status === 'Ativo' ? 'selected' : ''}>Ativo</option>
                <option value="Férias" ${status === 'Férias' ? 'selected' : ''}>Férias</option>
            `;

            const removeButton = document.createElement('button');
            removeButton.textContent = 'X';
            removeButton.className = 'btn btn-danger btn-sm employee-remove';
            removeButton.addEventListener('click', () => employeeItem.remove());

            employeeItem.appendChild(employeeName);
            employeeItem.appendChild(employeeStatus);
            employeeItem.appendChild(removeButton);

            employeeList.appendChild(employeeItem);
        }

        // Exemplo de funcionários
        addEmployee('Gabriel', 'Ativo');
        addEmployee('Bernadete', 'Férias');
    </script>
</body>
</html>
