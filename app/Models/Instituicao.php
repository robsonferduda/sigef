<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Instituicao extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.instituicao_ensino_superior_ies';
    protected $primaryKey = 'cd_instituicao_ies';

    protected $fillable = ['nm_instituicao_ies'];

    public function curso(){
        return $this->belongsTo('App\Models\Curso', 'cd_instituicao_ies', 'cd_instituicao_ies');
    } 

}