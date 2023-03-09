<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'concurso.estado_est';
    protected $primaryKey = 'cd_estado_est';

    protected $fillable = [];

    public $timestamps = false;
}
