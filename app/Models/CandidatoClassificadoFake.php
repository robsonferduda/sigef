<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CandidatoClassificadoFake extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_classificado_cac_fake';
    protected $primaryKey = 'cd_opcao_candidato_opc';

    protected $fillable = ['cd_opcao_candidato_opc', 'cd_categoria_evento_cae', 'nu_ordem_cac'];

    public $timestamps = false;

    public function opcao()
    {
        return $this->hasOne(OpcaoCandidatoFake::class, 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc');
    }

    public function categoria() {
        return $this->hasOne(CategoriaEventoFake::class, 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }
}
