<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacaoBoleto extends Model
{    
    
    protected $connection = 'pgsql';
    protected $table = 'util.informacao_boleto_ibo';
    protected $primaryKey = 'cd_informacao_ibo';

    protected $fillable = ['nu_convenio_ibo'];

    public function evento(){
        return $this->belongsTo('App\Models\Evento', 'cd_informacao_ibo', 'cd_informacao_ibo');
    } 

}