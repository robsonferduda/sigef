<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSala extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.tipo_sala_tis';
    protected $primaryKey = 'cd_tipo_sala_tis';

    protected $fillable = ['nm_tipo_tis'];

    public $timestamps = false;

}
