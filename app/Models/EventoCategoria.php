<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoCategoria extends Pivot
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.categoria_evento_cae';
    protected $primaryKey = 'cd_categoria_evento_cae';

    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'cd_categoria_cat', 'cd_categoria_cat');
    }
}