<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEventoFake extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.categoria_evento_cae_fake';
    protected $primaryKey = 'cd_categoria_evento_cae';

    protected $fillable = ['cd_categoria_cat', 'cd_evento_eve'];

    public function categoria()
    {
        return $this->hasOne('App\Models\Categoria', 'cd_categoria_cat', 'cd_categoria_cat');
    }
}
