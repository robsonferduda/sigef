<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RazaoIsencao extends Model
{

  protected $connection = 'pgsql';
  protected $table = 'processos_seletivos.razao_isencao_rai';

	protected $primaryKey = 'cd_razao_isencao_rai';

    protected $fillable = ['nm_razao_isencao_rai'		   
    					  ]; //whitelist de inserção

	public $timestamps = true;
	
}
