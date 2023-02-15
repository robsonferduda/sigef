<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CandidatoTipoProva extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_tipo_prova_ctp';
    protected $primaryKey = 'cd_candidato_tipo_prova_ctp';

    protected $fillable = ['cd_candidato_can', 'cd_tipo_prova_tip'];

    public function tipoProva()
    {
        return $this->hasOne(TipoProva::class, 'cd_tipo_prova_tip', 'cd_tipo_prova_tip');
    }

    public function candidato()
    {
        return $this->belongsTo('App\Models\Candidato', 'cd_candidato_can', 'cd_candidato_can');
    }

}
