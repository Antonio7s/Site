<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MedicoEspecialidade extends Pivot
{
    protected $table = 'medico_especialidade';

    // Caso precise permitir a atribuição em massa, defina os campos preenchíveis
    protected $fillable = ['medico_id', 'especialidade_id'];

    // Se tiver campos extras, adicione-os aqui, por exemplo:
    // protected $fillable = ['medico_id', 'especialidade_id', 'data_atribuicao'];
}
