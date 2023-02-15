<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class OpcaoCandidatoDesempateVw extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.opcao_candidato_desempate_vw';
}
