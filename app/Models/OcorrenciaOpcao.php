<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcorrenciaOpcao extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.ocorrencia_opcao_oco';
	protected $primaryKey = 'cd_ocorrencia_opcao_oco';
    protected $fillable = ['dc_ocorrencia_oco'];

    public $timestamps = false;
}