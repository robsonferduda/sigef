<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeEnsino extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.rede_ensino_ree';
    protected $primaryKey = 'cd_rede_ensino_ree';

    protected $fillable = [];

    public $timestamps = false;
}
