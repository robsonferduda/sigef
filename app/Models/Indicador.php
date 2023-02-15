<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{    
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.indicador_ind';
    protected $primaryKey = 'cd_indicador_ind';

    protected $fillable = ['nm_indicador_ind'];

    public function opcao(){
        return $this->belongsTo(OpcaoCandidato::class, 'cd_indicador_ind', 'cd_indicador_indm');
    } 

}