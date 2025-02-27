<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <!-- Incluindo o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Lista de Agendamentos</h1>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nome do Agendamento</th>
                    <th>Médico</th>
                    <th>Procedimento</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Preço</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Agendamento 1: Aguardando pagamento -->
                <tr>
                    <td>Consulta de rotina</td>
                    <td>Dr. João Silva</td>
                    <td>Consulta Geral</td>
                    <td>2025-03-10</td>
                    <td>10:00</td>
                    <td>R$ 200,00</td>
                    <td>
                        <span class="badge bg-warning text-dark">Aguardando pagamento</span>
                    </td>
                </tr>

                <!-- Agendamento 2: Agendado -->
                <tr>
                    <td>Exame de sangue</td>
                    <td>Dra. Maria Souza</td>
                    <td>Exame Laboratorial</td>
                    <td>2025-03-12</td>
                    <td>14:00</td>
                    <td>R$ 150,00</td>
                    <td>
                        <span class="badge bg-success">Agendado</span>
                    </td>
                </tr>

                <!-- Agendamento 3: Cancelado -->
                <tr>
                    <td>Consulta dermatológica</td>
                    <td>Dr. Carlos Oliveira</td>
                    <td>Consulta Dermatológica</td>
                    <td>2025-03-15</td>
                    <td>09:00</td>
                    <td>R$ 250,00</td>
                    <td>
                        <span class="badge bg-danger">Cancelado</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Incluindo o Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
