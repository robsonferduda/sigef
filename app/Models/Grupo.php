<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.evento_sala_evs';
    protected $primaryKey = 'cd_evento_sala_evs';

    protected $fillable = ['cd_evento_eef', 'cd_sala_sal', 'tipo_sala_tis_id','nu_carteiras_evs'];

    public $timestamps = false;

}