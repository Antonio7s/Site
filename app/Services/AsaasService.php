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



    // Método para criar cobrança (geralizado para PIX, BOLETO, etc.)
    public function criarCobranca($customerId, $valor, $descricao, $billingType = 'PIX')
    {
        // Buscar os splits no banco de dados (ajuste conforme o nome da sua tabela e os campos)
        //$splitsData = Clinica::where('customer_id', $customerId)->get();
        $splitsData = Clinica::where('id', 1)->get();

        // Prepara o array de splits com base nos dados do banco de dados.
        $splits = [];

        foreach ($splitsData as $split) {
            $splits[] = [
                'walletId'       => $split->wallet_id,          // ID da carteira do split
                'fixedValue'     => $split->valor_fixo_lucro,  // Valor fixo
                'percentualValue'=> $split->porcentagem_lucro, // Percentual
                //'totalFixedValue'=> $split->total_fixed_value, // Total fixo
                'description'    => 'SPLIT MEDEXAME',       // Descrição
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
                'billingType' => $billingType, // Pode ser 'PIX' ou 'BOLETO'
                'value'       => $valor,
                'cpfCnpj'   => '071.275.153-01', //chumbado
                'description' => $descricao,
                'dueDate'     => now()->addDays(5)->format('Y-m-d'),
                'splits'      => $splits, // Passa o array de splits aqui
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

    public function obterBoleto($paymentId)
    {
        $url = $this->baseUrl . "payments/{$paymentId}";

        $response = $this->client->get($url, [
            'headers' => [
                'accept' => 'application/json',
                'access_token' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
}


}
