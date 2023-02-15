<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SituacaoCondicaoEspecial extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.situacao_condicao_especial_sce';
    protected $primaryKey = 'cd_situacao_condicao_especial_sce';

    protected $fillable = ['nm_situacao_sce'];
}