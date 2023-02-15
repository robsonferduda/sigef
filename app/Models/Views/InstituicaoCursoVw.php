<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class InstituicaoCursoVw extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.instituicao_curso_vw';
}
