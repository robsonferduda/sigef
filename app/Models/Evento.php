<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.evento_espaco_fisico_eef';
    protected $primaryKey = 'cd_evento_eef';

    protected $fillable = [];

    public $timestamps = false;

    public function tipo()
    {
        return $this->hasOne(TipoEvento::class, 'cd_tipo_evento_tie', 'cd_tipo_evento_tie');
    }
}