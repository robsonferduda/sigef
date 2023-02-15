<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoEventoFake extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_evento_cue_fake';
    protected $primaryKey = 'cd_curso_evento_cue';


    public function categorias() {
        $this->hasMany(CategoriaEventoFake::class, 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }

}
