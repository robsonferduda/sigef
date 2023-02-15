<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CandidatoFake extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_can_fake';
    protected $primaryKey = 'cd_candidato_can';

    public function categoria()
    {
        return $this->hasOne(CategoriaEventoFake::class, 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }

}
