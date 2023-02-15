<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CandidatoPresenca extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_presenca_cap';
    protected $primaryKey = 'id_candidato_presenca_cap';

    
}