<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsaasController extends Controller
{
    /**
     * Processa as notificações do webhook do Asaas.
     */
    public function webhook(Request $request)
    {
        // Dados recebidos do Asaas
        $data = $request->all();

        // Verifique o status do pagamento
        if (isset($data['status']) && $data['status'] == 'PAID') {
            // O pagamento foi confirmado, você pode realizar as ações necessárias aqui.
            // Exemplo: atualizar o status do pedido ou notificar o usuário.

            // Aqui você pode, por exemplo, salvar os dados em seu banco ou fazer outra ação.
            // Suponhamos que você tenha um modelo de Pedido:
            // Pedido::where('id', $data['paymentId'])->update(['status' => 'pago']);
        }

        // Retorne uma resposta adequada
        return response()->json(['message' => 'Webhook recebido com sucesso'], 200);
    }
}
