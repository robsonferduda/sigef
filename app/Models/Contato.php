<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.contato_con';
    protected $primaryKey = 'cd_contato_con';

    protected $fillable = [];

    public $timestamps = false;
}
