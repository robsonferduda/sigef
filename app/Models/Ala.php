<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ala extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.ala_ala';
    protected $primaryKey = 'cd_ala_ala';

    protected $fillable = [''];

    
    public function setorEvento()
    {
        return $this->hasOne(SetorEvento::class, 'cd_setor_evento_see', 'cd_setor_evento_see');
    }

}