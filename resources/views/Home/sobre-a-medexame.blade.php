<?php
    $titulo = "Sobre a MedExame";
    $empresa = "MedExame";
    $email_contato = "contato@medexame.com";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4cb3f7;
            font-size: 2em;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: justify;
        }
        .highlight {
            color: #4cb3f7;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
        }
        .footer a {
            color: #4cb3f7;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $titulo; ?></h1>
        <p>A <span class="highlight"><?php echo $empresa; ?></span> é uma plataforma inovadora que conecta pacientes a diversos consultórios parceiros, oferecendo uma ampla variedade de consultas e exames médicos de forma acessível e prática.</p>
        <p>Nossa missão é proporcionar saúde e bem-estar por meio de um serviço confiável, com preços acessíveis e com a <span class="highlight">comodidade</span> que você merece. Com poucos cliques, você pode agendar consultas e exames com profissionais qualificados e em locais de confiança.</p>
        <p>Trabalhamos com um modelo que valoriza a sua <span class="highlight">praticidade</span>, garantindo que todo o processo seja rápido, intuitivo e seguro. Além disso, nossos parceiros foram cuidadosamente selecionados para oferecer o melhor atendimento.</p>
        <p>Escolha a <span class="highlight"><?php echo $empresa; ?></span> e tenha acesso a cuidados médicos de qualidade, com transparência, eficiência e a melhor experiência para o paciente.</p>
    </div>
    <div class="footer">
        <p>Entre em contato conosco: <a href="mailto:<?php echo $email_contato; ?>"><?php echo $email_contato; ?></a></p>
    </div>
</body>
</html>
