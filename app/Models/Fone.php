<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fone extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.fone_fon';
	protected $primaryKey = 'cd_fone_fon';

    protected $fillable = ['cd_candidato_can',
              					   'nu_ddi_fon',
              					   'nu_ddd_fon',
                           'nu_fone_fon',
                           'cd_tipo_tfo',
                           'fl_principal_fon'
    					  ]; //whitelist de inserção

    public $timestamps = false;
}
