<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Categoria extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.categoria_cat';
    protected $primaryKey = 'cd_categoria_cat';

    protected $fillable = ['nm_categoria_cat','nu_categoria_cat'];

    public function evento()
    {
        return $this->belongsToMany('App\Models\Evento','processos_seletivos.categoria_evento_cae','cd_categoria_cat','cd_evento_eve')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($controle) {	 
            
	    });
    }
}