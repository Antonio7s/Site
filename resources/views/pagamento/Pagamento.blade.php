@extends('layouts.appusuarioautentificado')

    <title>Finalizar Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #333;
        }

        .order-summary {
            margin-bottom: 30px;
        }

        .order-summary p {
            font-size: 1.2em;
            color: #555;
            margin: 5px 0;
        }

        .order-summary .total-price {
            font-size: 1.5em;
            color: #4CAF50;
            font-weight: bold;
        }

        .payment-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .payment-options label {
            display: block;
            font-size: 1em;
            margin-bottom: 5px;
        }

        .payment-options select, .payment-options input {
            width: 48%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .credit-card-details {
            display: none;
            flex-direction: column;
            width: 100%;
        }

        .credit-card-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .credit-card-row input {
            flex: 1;
        }

        .submit-button {
            text-align: center;
        }

        .submit-button input[type="submit"] {
            width: 100%;
            padding: 12px;
            font-size: 1.2em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-button input[type="submit"]:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .payment-options {
                flex-direction: column;
                align-items: stretch;
            }

            .payment-options select, .payment-options input {
                width: 100%;
                margin-bottom: 10px;
            }

            .credit-card-row {
                flex-direction: column;
            }
        }
    </style>
    <script>
        function toggleCreditCardDetails() {
            const paymentMethod = document.getElementById("payment-method").value;
            const creditCardDetails = document.querySelector(".credit-card-details");
            creditCardDetails.style.display = paymentMethod === "credit-card" ? "flex" : "none";
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Finalizar Pagamento</h2>

        <!-- Resumo do Pedido -->
        <div class="order-summary">
            <p><strong>Consulta:</strong> <input type="text" name="consulta" placeholder="Nome da consulta/exame" required></p>
            <p><strong>Quantidade:</strong> <input type="number" name="quantidade" value="1" min="1" required></p>
            <p class="total-price"><strong>Total:</strong> <span id="total-value">R$ 150.00</span></p>
        </div>

        <!-- Formulário de pagamento -->
        <form action="processar_pagamento.php" method="post">
            <!-- Opção de pagamento -->
            <div class="payment-options">
                <label for="payment-method">Método de pagamento</label>
                <select id="payment-method" name="payment-method" onchange="toggleCreditCardDetails()" required>
                    <option value="">Escolha um método</option>
                    <option value="credit-card">Cartão de Crédito</option>
                    <option value="bank-slip">Boleto Bancário</option>
                </select>
            </div>

            <!-- Detalhes do Cartão de Crédito -->
            <div class="credit-card-details">
                <label for="card-number">Número do Cartão</label>
                <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" required>

                <div class="credit-card-row">
                    <div>
                        <label for="card-expiration">Validade (MM/AA)</label>
                        <input type="text" id="card-expiration" name="card-expiration" placeholder="MM/AA" required>
                    </div>
                    <div>
                        <label for="card-cvc">CVC</label>
                        <input type="text" id="card-cvc" name="card-cvc" placeholder="123" required>
                    </div>
                </div>
            </div>

            <!-- Botão de envio -->
            <div class="submit-button">
                <input type="submit" value="Confirmar Pagamento">
            </div>
        </form>

        <div class="footer">
            <p>Ou entre em contato conosco: <a href="mailto:contato@medexame.com">contato@medexame.com</a></p>
        </div>
    </div>

@endsection
