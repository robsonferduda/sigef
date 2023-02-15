<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnderecoEletronico extends Model
{

	protected $table = 'processos_seletivos.endereco_eletronico_ene';

	protected $primaryKey = 'cd_endereco_eletronico_ene';

    protected $fillable = ['cd_candidato_can',
    					   'nm_endereco_ene',
    					   'cd_tipo_tee',
    					   'fl_principal_ene'
    					  ]; 

    public $timestamps = false;
}