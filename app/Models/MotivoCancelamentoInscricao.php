<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MotivoCancelamentoInscricao extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.motivo_cancelamento_inscricao_moc';
    protected $primaryKey = 'cd_motivo_cancelamento_inscricao_moc';

    protected $fillable = ['nm_motivo_cancelamento_inscricao_moc'];

}