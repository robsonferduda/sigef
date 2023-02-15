<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class OpcaoCandidatoFake extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.opcao_candidato_opc_fake';
    protected $primaryKey = 'cd_opcao_candidato_opc';

    protected $fillable = [''];

    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function candidato() {
        return $this->hasOne(CandidatoFake::class, 'cd_candidato_can', 'cd_candidato_can');
    }

    public function cursoEvento()
    {
        return $this->hasOne('App\Models\CursoEventoFake', 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

    public function classificado()
    {
        return $this->hasOne('App\Models\CandidatoClassificadoFake', 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc');
    }

}
