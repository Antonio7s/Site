<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Voucher de Agendamento</title>
</head>
<body>
    <h1>Olá, {{ $agendamento->user->name }}!</h1>
    <p>
        Seu agendamento foi realizado com sucesso para o dia {{ date('d/m/Y', strtotime($agendamento->data)) }}.
    </p>
    <p>
        Utilize o voucher <strong>{{ $agendamento->voucher }}</strong> na clínica para identificação.
    </p>
    <p>
        Até breve!
    </p>
</body>
</html>
