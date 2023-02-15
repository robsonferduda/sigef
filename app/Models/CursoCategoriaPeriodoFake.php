<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoCategoriaPeriodoFake extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_categoria_periodo_ccp_fake';
    protected $primaryKey = 'cd_curso_categoria_periodo_ccp';

    protected $fillable = ['cd_curso_evento_cue', 'cd_categoria_evento_cae', 'cd_evento_periodo_evp','nu_vagas_originais_ccp', 'nu_vagas_ocupadas_ccp'];

    public function cursoEvento()
    {
        return $this->hasOne('App\Models\CursoEvento', 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

    public function categoria()
    {
        return $this->hasOne('App\Models\CategoriaEventoFake', 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }
}
