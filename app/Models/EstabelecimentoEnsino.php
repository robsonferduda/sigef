<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstabelecimentoEnsino extends Model
{
	protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.estabelecimento_ensino_ese';
	protected $primaryKey = 'cd_estabelecimento_ensino_ese';

    public $timestamps = false;

    protected $fillable = [
                            'nm_estabelecimento_ensino_ese',
                            'cd_municipio_mun',
                            'en_bairro_ese',
                            'en_cep_ese',
                            'nu_fone_ese'
    					   ];
}
