<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Clinica;

class AsaasService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('ASAAS_API_KEY');
        $this->baseUrl = env('ASAAS_BASE_URL', 'https://api-sandbox.asaas.com/v3/');
    }



    // Método para criar cobrança Pix
    public function criarCobrancaPix($customerId, $valor, $descricao,  $clinica_id, $cpfCliente)
    {
        // Buscar os splits no banco de dados (ajuste conforme o nome da sua tabela e os campos)
        //$splitsData = Clinica::where('customer_id', $customerId)->get();
        $splitsData = Clinica::where('id',  $clinica_id)->get();

        // Prepara o array de splits com base nos dados do banco de dados.
        $splits = [];

        foreach ($splitsData as $split) {
            $splits[] = [
                'walletId'       => $split->wallet_id,          // ID da carteira do split
                'fixedValue'     => $split->valor_fixo_lucro,  // Valor fixo
                'percentualValue'=> $split->porcentagem_lucro, // Percentual
                //'totalFixedValue'=> $split->total_fixed_value, // Total fixo
                'description'    => $descricao,       // Descrição
            ];
        }

        $response = $this->client->post("{$this->baseUrl}payments", [
            'headers' => [
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
                'access_token'  => $this->apiKey,
            ],
            'json' => [
                'customer'    => $customerId,
                'billingType' => 'PIX', // Pode ser 'PIX' ou 'BOLETO'
                'value'       => $valor,
                'cpfCnpj'   => $cpfCliente, //000.000.000-00
                'description' => $descricao,
                'dueDate'     => now()->addDays(5)->format('Y-m-d'),
                'splits'      => $splits, // Passa o array de splits aqui
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    // Novo método para criar cobrança via Cartão de Crédito
    public function criarCobrancaCartao($customerId, $valor, $descricao, array $creditCard, $clinica_id, $installments = 1)
    {
        // Buscar os dados dos splits conforme a clínica
        $splitsData = Clinica::where('id', $clinica_id)->get();
        $splits = [];

        foreach ($splitsData as $split) {
            $splits[] = [
                'walletId'        => $split->wallet_id,
                'fixedValue'      => $split->valor_fixo_lucro,
                'percentualValue' => $split->porcentagem_lucro,
                'description'     => $descricao,
            ];
        }

        $response = $this->client->post("{$this->baseUrl}payments", [
            'headers' => [
                'accept'       => 'application/json',
                'content-type' => 'application/json',
                'access_token' => $this->apiKey,
            ],
            'json' => [
                'customer'         => $customerId,
                'billingType'      => 'CREDIT_CARD', // Define pagamento via cartão de crédito
                'value'            => $valor,
                'description'      => $descricao,
                // Dados do cartão
                'creditCard'       => [
                    'creditCardNumber'          => $creditCard['number'],
                    'creditCardHolderName'      => $creditCard['holderName'],
                    'creditCardExpirationMonth' => $creditCard['expirationMonth'],
                    'creditCardExpirationYear'  => $creditCard['expirationYear'],
                    'creditCardCVV'             => $creditCard['cvv'],
                ],
                'installmentCount' => $installments,
                'splits'           => $splits, // Inclui os splits se necessário
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    // Método para criar cliente no Asaas
    public function criarCliente($nome, $cpf, $email, $telefone)
    {
        $response = $this->client->post("{$this->baseUrl}customers", [
            'headers' => [
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
                'access_token'  => $this->apiKey,
            ],
            'json' => [
                'name'      => $nome,
                'cpfCnpj'   => $cpf,
                'email'     => $email,
                //'mobilePhone'=> $telefone,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function obterQrCodePix($paymentId)
    {
        $url = $this->baseUrl . "payments/{$paymentId}/pixQrCode";

        $response = $this->client->get($url, [
            'headers' => [
                'accept' => 'application/json',
                'access_token' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }


}
