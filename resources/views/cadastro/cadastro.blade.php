@extends('layouts.app') <!-- Referencia o layout 'app.blade.php' -->

@section('content')

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .hidden {
                display: none;
            }
            #selecao {
                text-align: center;
            }
            #selecao p {
                font-size: 1.2rem;
                font-weight: bold;
                margin-bottom: 20px;
            }
            .choice-btn {
                width: 200px;
                height: 100px;
                font-size: 1.2rem;
                font-weight: bold;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
            }
            .choice-btn i {
                margin-right: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <h2 class="text-center">Cadastro</h2>

            <!-- Janela de Seleção -->
            <div id="selecao" class="mb-4">
                <p>Por favor, escolha uma opção:</p>
                <div class="d-flex justify-content-center gap-3">
                    <button class="btn btn-outline-primary choice-btn" id="btnPaciente">
                        <i class="bi bi-person-circle"></i> Paciente
                    </button>
                    <button class="btn btn-outline-success choice-btn" id="btnClinica">
                        <i class="bi bi-hospital"></i> Clínica Médica
                    </button>
                </div>
            </div>

            <!-- Formulário para Paciente -->
            <form id="formPaciente" class="hidden">
                <h3>Cadastro de Paciente</h3>
                <div class="mb-3">
                    <label for="nomePaciente" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nomePaciente" placeholder="Digite seu nome" required>
                </div>
                <div class="mb-3">
                    <label for="emailPaciente" class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailPaciente" placeholder="Digite seu email" required>
                </div>
                <div class="mb-3">
                    <label for="estadoPaciente" class="form-label">Estado</label>
                    <select class="form-control" id="estadoPaciente" required>
                        <option value="">Selecione seu estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cidadePaciente" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidadePaciente" placeholder="Digite sua cidade" required>
                    <ul id="cidadeSugestoes" class="list-group mt-2"></ul>
                </div>
                <div class="mb-3">
                    <p>Você deseja:</p>
                    <div>
                        <input type="radio" id="consulta" name="tipoServico" value="consulta" required>
                        <label for="consulta">Consulta</label>
                    </div>
                    <div>
                        <input type="radio" id="exame" name="tipoServico" value="exame" required>
                        <label for="exame">Exame</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Paciente</button>
            </form>

            <!-- Formulário para Clínica Médica -->
            <form id="formClinica" class="hidden">
                <h3>Cadastro de Clínica Médica</h3>
                <div class="mb-3">
                    <label for="nomeClinica" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nomeClinica" required>
                </div>
                <div class="mb-3">
                    <label for="cpfClinica" class="form-label">CPF/CNPJ</label>
                    <input type="text" class="form-control" id="cpfClinica" required>
                </div>
                <div class="mb-3">
                    <label for="nomeInstituicao" class="form-label">Nome da Clínica</label>
                    <input type="text" class="form-control" id="nomeInstituicao" required>
                </div>
                <a href="cadastro/analise" type="submit" class="btn btn-success">Cadastrar Clínica</a>
            </form>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- Script de Controle -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const btnPaciente = document.getElementById("btnPaciente");
                const btnClinica = document.getElementById("btnClinica");
                const formPaciente = document.getElementById("formPaciente");
                const formClinica = document.getElementById("formClinica");
                const selecao = document.getElementById("selecao");
                const estadoSelect = document.getElementById("estadoPaciente");
                const cidadeInput = document.getElementById("cidadePaciente");
                const sugestoesContainer = document.getElementById("cidadeSugestoes");

                let cidadesPorEstado = {};

                // Carregar lista de cidades agrupadas por estado
                fetch("https://servicodados.ibge.gov.br/api/v1/localidades/municipios")
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(cidade => {
                            const estado = cidade.microrregiao.mesorregiao.UF.sigla;
                            if (!cidadesPorEstado[estado]) {
                                cidadesPorEstado[estado] = [];
                            }
                            cidadesPorEstado[estado].push(cidade.nome);
                        });
                    });

                // Mostrar formulário de Paciente
                btnPaciente.addEventListener("click", function () {
                    selecao.style.display = "none";
                    formPaciente.classList.remove("hidden");
                });

                // Mostrar formulário de Clínica Médica
                btnClinica.addEventListener("click", function () {
                    selecao.style.display = "none";
                    formClinica.classList.remove("hidden");
                });

                // Atualizar sugestões de cidades ao selecionar um estado
                estadoSelect.addEventListener("change", function () {
                    const estado = estadoSelect.value;
                    cidadeInput.value = "";
                    sugestoesContainer.innerHTML = "";

                    if (estado && cidadesPorEstado[estado]) {
                        cidadeInput.addEventListener("input", function () {
                            const query = cidadeInput.value.toLowerCase();
                            sugestoesContainer.innerHTML = "";

                            if (query.length > 0) {
                                const sugestoes = cidadesPorEstado[estado].filter(cidade =>
                                    cidade.toLowerCase().startsWith(query)
                                );

                                sugestoes.forEach(cidade => {
                                    const li = document.createElement("li");
                                    li.textContent = cidade;
                                    li.classList.add("list-group-item");
                                    li.addEventListener("click", function () {
                                        cidadeInput.value = cidade;
                                        sugestoesContainer.innerHTML = "";
                                    });
                                    sugestoesContainer.appendChild(li);
                                });
                            }
                        });
                    }
                });
            });
        </script>
    </body>
    </html>
@endsection