<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AvaliacaoISencao extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.avaliacao_isencao_avi';
    protected $primaryKey = 'cd_avaliacao_isencao_avi';

    protected $fillable = ['cd_isentos_ise', 
                            'cd_usuario_usu', 
                            'cd_usuario_revisao_usu', 
                            'cd_isencao_indeferimento_isi', 
                            'nu_avaliacao_avi', 
                            'fl_deferimento_avi', 
                            'fl_duvida_avi'];

    public function isento(){
        return $this->hasOne(Isento::class, 'cd_isentos_ise', 'cd_isentos_ise');
    } 

    public function indeferimento(){
        return $this->hasOne(IsencaoIndeferimento::class, 'cd_isencao_indeferimento_isi', 'cd_isencao_indeferimento_isi');
    }

    public function usuario(){
        return $this->hasOne('App\User', 'id', 'cd_usuario_usu');
    } 

    public function revisor(){
        return $this->hasOne('App\User', 'id', 'cd_usuario_revisao_usu');
    } 
}