<?php

namespace App\Services;

use GuzzleHttp\Client;

class AsaasService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('ASAAS_API_KEY'); // Pegando do .env
        $this->baseUrl = env('ASAAS_BASE_URL', 'https://api-sandbox.asaas.com/v3/');
    }

    public function criarCobranca($customerId, $valor, $descricao)
    {
        $response = $this->client->post("{$this->baseUrl}payments", [
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'access_token' => $this->apiKey,
            ],
            'json' => [
                'customer' => $customerId,
                'billingType' => 'BOLETO', // Pode ser PIX, CREDIT_CARD, etc.
                'value' => $valor,
                'description' => $descricao,
                'dueDate' => now()->addDays(5)->format('Y-m-d'),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
