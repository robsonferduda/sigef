<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventoPeriodo extends Pivot
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.evento_periodo_evp';
    protected $primaryKey = 'cd_evento_periodo_evp';

    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }
}
