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

        // Captura o remoteIp, por exemplo:
        $remoteIp = request()->ip(); // ou use $_SERVER['REMOTE_ADDR'] se preferir

        // Monta o payload da requisição
        $payload = [
            'customer'    => $customerId,
            'billingType' => 'PIX',
            'value'       => $valor,
            'cpfCnpj'     => $cpfCliente, // Certifique-se de enviar somente dígitos
            'description' => $descricao,
            'dueDate'     => now()->addDays(5)->format('Y-m-d'),
            'splits'      => $splits,
            //'remoteIp'    => $remoteIp, // Caso a API exija o envio do IP
        ];

        // Loga o payload enviado no arquivo de log
        \Log::info('=== PAYLOAD PIX ENVIADO AO ASAAS ===', $payload);

        try {
            // Executa a requisição para criar a cobrança via PIX
            $response = $this->client->post("{$this->baseUrl}payments", [
                'debug'   => fopen('php://stdout', 'w'),
                'headers' => [
                    'accept'       => 'application/json',
                    'content-type' => 'application/json',
                    'access_token' => $this->apiKey,
                ],
                'json' => $payload,  // Envia o payload
            ]);
            
            $responseBody = json_decode($response->getBody(), true);
            
            // Loga a resposta do Asaas no arquivo de log
            \Log::info('=== RESPOSTA DO ASAAS - SERVIÇO ===', $responseBody);

            return $responseBody;
        
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Log detalhado em caso de erro, incluindo status, headers e corpo da resposta
            \Log::error('Erro na requisição ao Asaas', [
                'status_code' => $e->getResponse()->getStatusCode(),
                'headers'     => $e->getResponse()->getHeaders(),
                'response'    => (string) $e->getResponse()->getBody(),
            ]);
    
            // Retorna um array com a mensagem de erro para tratamento posterior
            return [
                'error'    => 'Erro ao realizar a requisição',
                'detalhes' => $e->getMessage()
            ];
        }
    }

    public function criarCobrancaCartao($customerId, $valor, $descricao, array $creditCard, $clinica_id, $postalCode, $addressNumber, $nomeCliente, $cpfCliente, $emailCliente, $telefoneCliente)
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
    
        $remoteIp = request()->ip(); // Captura o IP remoto
    
        // Monta o payload da requisição
        $payload = [
            'customer'         => $customerId,
            'billingType'      => 'CREDIT_CARD',
            'value'            => $valor,
            'dueDate'     => now()->addDays(5)->format('Y-m-d'),
            'description'      => $descricao,
            'creditCard'       => [
                'number'      => $creditCard['number'],
                'holderName'  => $creditCard['holderName'],
                'expiryMonth' => $creditCard['expirationMonth'],
                'expiryYear'  => $creditCard['expirationYear'],
                'ccv'         => $creditCard['cvv'],
            ],
            'creditCardHolderInfo' => [
                'name'          => $nomeCliente,
                'email'         => $emailCliente ?? '',
                'cpfCnpj'       => $cpfCliente ?? '',
                'postalCode'    => $postalCode ?? '',
                'addressNumber' => $addressNumber ?? '',
                'phone'         => $telefoneCliente ?? '',
            ],
            'remoteIp' => $remoteIp,
            'splits'   => $splits,
        ];
    
        // Exibe o payload no console
        echo "\n\n=== PAYLOAD ENVIADO AO ASAAS ===\n";
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n==========================\n";
    
        \Log::info('=== PAYLOAD ENVIADO AO ASAAS ===', $payload);
    
        try {
            $response = $this->client->post("{$this->baseUrl}payments", [
                'debug' => fopen('php://stdout', 'w'),
                'headers' => [
                    'accept'       => 'application/json',
                    'content-type' => 'application/json',
                    'access_token' => $this->apiKey,
                ],
                'json' => $payload,
            ]);
    
            $responseBody = json_decode($response->getBody(), true);
    
            echo "\n\n=== RESPOSTA DO ASAAS ===\n";
            print_r($responseBody);
            echo "\n==========================\n";
    
            \Log::info('=== RESPOSTA DO ASAAS -SERVICE ===', $responseBody);
    
            return $responseBody;
    
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            echo "\n\n=== ERRO NA REQUISIÇÃO ===\n";
    
            if ($e->hasResponse()) {
                $errorBody = (string) $e->getResponse()->getBody();
                echo $errorBody;
                \Log::error('Erro na requisição ao Asaas', ['response' => $errorBody]);
            } else {
                echo $e->getMessage();
                \Log::error('Erro sem resposta do Asaas', ['exception' => $e]);
            }
    
            echo "\n==========================\n";
    
            return ['error' => 'Erro ao realizar a requisição', 'detalhes' => $e->getMessage()];
        }
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
