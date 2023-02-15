<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CondicaoEspecial extends Model implements Auditable
{    
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.condicao_especial_coe';
    protected $primaryKey = 'cd_condicao_especial_coe';

    protected $fillable = ['nm_condicao_especial_coe'];

    public function condicaoEvento(){
        return $this->belongsTo(CondicaoEspecialEvento::class, 'cd_condicao_especial_coe','cd_condicao_especial_coe');
    }

    public function eventos(){
        return $this->belongsToMany(Evento::class, 'processos_seletivos.condicao_especial_evento_cee','cd_condicao_especial_coe','cd_evento_eve')->withTimestamps();
    }
}