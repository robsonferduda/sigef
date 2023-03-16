<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCarteira extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.tipo_carteira_tic';
    protected $primaryKey = 'cd_tipo_carteira_tic';

    protected $fillable = ['nm_tipo_tic'];

    public $timestamps = false;

}
