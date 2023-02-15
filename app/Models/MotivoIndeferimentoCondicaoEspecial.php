<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MotivoIndeferimentoCondicaoEspecial extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.motivo_indeferimento_condicao_especial_mic';
    protected $primaryKey = 'cd_motivo_indeferimento_condicao_especial_mic';

    protected $fillable = ['nm_motivo_indeferimento_condicao_especial_mic'];

}