<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CursoCategoria extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_categoria_cuc';
    protected $primaryKey = 'cd_curso_categoria_cuc';

    public $timestamps = false;

    protected $fillable = ['cd_curso_evento_cue', 'cd_categoria_evento_cae', 'nu_vagas_originais_cuc', 'nu_vagas_ocupadas_cuc'];

    public function cursoEvento()
    {
        return $this->hasOne('App\Models\CursoEvento', 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

    public function categoria()
    {
        return $this->hasOne('App\Models\CategoriaEvento', 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }
}
