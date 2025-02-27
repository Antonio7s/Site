<?php

namespace App\Http\Controllers;

use App\Models\Agendamento; 
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
        if (isset($data['payment']['status']) && $data['payment']['status'] == 'RECEIVED') {
            // O pagamento foi confirmado, verifique se existe um agendamento com o id do pagamento
            $paymentId = $data['payment']['id'];

            // Buscar o agendamento associado ao pagamento pelo 'paymentId'
            $agendamento = Agendamento::where('pagamento_id', $paymentId)->first();

            if ($agendamento) {
                // Se o agendamento for encontrado, altere seu status para 'agendado'
                $agendamento->status = 'agendado';
                $agendamento->save();
                
                // Aqui você pode adicionar qualquer outra ação necessária, como enviar uma notificação
            }
        }

        // Retorne uma resposta adequada
        return response()->json(['message' => 'Webhook recebido com sucesso'], 200);
    }
}
