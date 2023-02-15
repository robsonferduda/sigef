<?php

namespace App\Models;

use DB;
use App\Enums\TipoDocumento;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'pessoa.pessoa_pes';
	protected $primaryKey = 'cd_pessoa_pes';

    protected $fillable = ['nm_pessoa_pes',
    					   'dt_nascimento_pes',
    					   'cd_sexo_pes',
    					   'cd_raca_rac',
    					   'fl_canhoto_pes',
    					   'nm_nome_social_pes',
    					   'cd_sexo_sex',
    					   'nm_mae_pes',
                           'fl_estrangeiro_pes'
    					   ];

	public function cpf()
	{
	   return $this->hasOne(Documento::class, 'cd_pessoa_pes', 'cd_pessoa_pes')->where('cd_tipo_tpd', TipoDocumento::CPF);
    }
					   
	public function identidade()
	{
		return $this->hasOne(Documento::class, 'cd_pessoa_pes', 'cd_pessoa_pes')->where('cd_tipo_tpd', TipoDocumento::IDENTIDADE);
	}

	public function candidato(){
		return $this->hasOne('App\Models\Candidato', 'cd_pessoa_pes', 'cd_pessoa_pes');
	}

	public function usuario(){
    	return $this->hasOne('App\Models\User', 'cd_pessoa_pes', 'cd_pessoa_pes');
    }

	public function raca()
    {
        return $this->hasOne(Raca::class, 'cd_raca_rac','cd_raca_rac');
    }

    public function sexo(){
    	return $this->hasOne(Sexo::class, 'cd_sexo_sex', 'cd_sexo_sex');
    }

	public function getEmailDistinct()
	{
		return DB::connection('pgsql')->select("SELECT distinct t3.nm_endereco_ene 
							from processos_seletivos.candidato_can t1, pessoa.pessoa_pes t2, processos_seletivos.endereco_eletronico_ene t3
							where t1.cd_pessoa_pes = t2.cd_pessoa_pes 
							and t1.cd_candidato_can = t3.cd_candidato_can 
							and t1.cd_pessoa_pes = ".$this->cd_pessoa_pes);
	}
}