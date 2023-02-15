<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Isencao extends Model
{

  protected $connection = 'pgsql';
  protected $table = 'processos_seletivos.isencao_isn';

	protected $primaryKey = 'cd_isencao_isn';

    protected $fillable = ['dc_isencao_isn',
    					   'dt_iniciao_isn',
    					   'dt_fim_isn',
                           'cd_evento_eve',
                           'cd_razao_isencao_rai'				   
    					  ]; //whitelist de inserção

	public $timestamps = false;

  public function razaoIsencao(){
        return $this->hasOne('App\Models\RazaoIsencao', 'cd_razao_isencao_rai', 'cd_razao_isencao_rai');
    }
	
}
