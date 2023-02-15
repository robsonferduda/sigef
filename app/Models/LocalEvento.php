<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalEvento extends Pivot
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.local_prova_evento_lpe';
    protected $primaryKey = 'cd_local_prova_evento_lpe';

    public function local()
    {
        return $this->belongsTo('App\Models\Local', 'cd_local_prova_lop', 'cd_local_prova_lop');
    }

}