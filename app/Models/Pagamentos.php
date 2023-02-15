<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamentos extends Model 
{
	
	protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.candidato_can';
	protected $primaryKey = 'cd_candidato_can';
	protected $fillable	 = ['cd_candidato_can, cd_pessoa_pes,cd_tipo_homologacao_candidato_thc,fl_inscricao_homologada_can,dt_inscricao_homologada_can'];
	
    
	
	public function tipoHomologacaoInscricao()
	{	
		return $this->hasOne('App\Models\TipoHomologacaoInscricao','cd_tipo_homologacao_candidato_thc','cd_tipo_homologacao_candidato_thc');
	}
	
			
}