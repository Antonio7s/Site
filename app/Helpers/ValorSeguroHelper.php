<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class ValorSeguroHelper
{
    /**
     * Assina os dados (valor e horário) e retorna um token criptografado.
     *
     * @param float $valor
     * @param int $horario_id
     * @return string
     */
    public static function assinar($valor, $horario_id)
    {
        $dados = [
            'valor' => $valor,
            'horario_id' => $horario_id,
        ];

        return Crypt::encryptString(json_encode($dados));
    }

    /**
     * Descriptografa e verifica os dados do token.
     *
     * @param string $token
     * @return array
     */
    public static function verificar($token)
    {
        $dados = json_decode(Crypt::decryptString($token), true);
        return $dados;
    }
}
