<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetorEvento extends Pivot
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.setor_evento_see';
    protected $primaryKey = 'cd_setor_evento_see';

    public function setor()
    {
        return $this->belongsTo('App\Models\Setor', 'cd_setor_sel', 'cd_setor_sel');
    }

    public function localEvento()
    {
        return $this->belongsTo('App\Models\LocalEvento', 'cd_local_prova_evento_lpe', 'cd_local_prova_evento_lpe');
    }

    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function grupo()
    {
        return $this->hasMany('App\Models\Grupo', 'cd_setor_evento_see', 'cd_setor_evento_see');
    }
}