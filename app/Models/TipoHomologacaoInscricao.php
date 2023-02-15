<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHomologacaoInscricao extends Model
{

	protected $table = 'processos_seletivos.tipo_homologacao_candidato_thc';	
	protected $primaryKey = 'cd_tipo_homologacao_candidato_thc';
	protected $fillable = ['cd_tipo_homologacao_candidato_thc','nm_tipo_homologacao_thc'];

	public $timestamps = true;

}