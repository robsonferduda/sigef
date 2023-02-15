<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEvento extends Model 
{    
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.categoria_evento_cae';
    protected $primaryKey = 'cd_categoria_evento_cae';

    protected $fillable = ['cd_categoria_cat', 'cd_evento_eve', 'fl_paa_cae', 'dc_texto_informativo_cae'];


    public function categoria()
    {
        return $this->hasOne('App\Models\Categoria', 'cd_categoria_cat', 'cd_categoria_cat');
    }

    public function evento()
    {
        return $this->hasOne('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }
}