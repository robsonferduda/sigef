<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.tipo_evento_tie';
    protected $primaryKey = 'cd_tipo_evento_tie';

    protected $fillable = [];

    public $timestamps = false;
}