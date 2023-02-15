<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoParametros extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.evento_parametros_evp';
    protected $primaryKey = 'cd_evento_parametros_evp';

    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

}