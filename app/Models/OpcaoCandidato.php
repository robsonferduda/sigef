<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class OpcaoCandidato extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.opcao_candidato_opc';
    protected $primaryKey = 'cd_opcao_candidato_opc';

    protected $fillable = [''];

    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function cursoEvento()
    {
        return $this->belongsTo('App\Models\CursoEvento', 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

    public function candidato() {
        return $this->hasOne(Candidato::class, 'cd_candidato_can', 'cd_candidato_can');
    }

    public function classificado()
    {
        return $this->hasOne('App\Models\CandidatoClassificado', 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc');
    }

    public function pontuacao()
    {
        return $this->hasOne(PontoCandidato::class, 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc');
    }

    public function indicador()
    {
        return $this->hasOne(Indicador::class, 'cd_indicador_ind', 'cd_indicador_ind');
    }

    public function ocorrencia()
    {
        return $this->hasOne(OcorrenciaOpcao::class, 'cd_ocorrencia_opcao_oco', 'cd_ocorrencia_opcao_oco');
    }
}
