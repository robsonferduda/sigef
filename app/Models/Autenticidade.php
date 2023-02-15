<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autenticidade extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.autenticidade_aut';

    protected $primaryKey = 'cd_autenticidade_aut';

    protected $fillable = [
        'hash_aut','cd_evento_eve','nm_proprietario_aut','ds_texto_aut'
    ];

    public $timestamps = true;
}