<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'pessoa.documento_doc';
	protected $primaryKey = 'cd_documento_doc';

    protected $fillable = ['cd_pessoa_pes',
    					   'cd_tipo_tpd',
    					   'nm_documento_doc',
    					   'cd_orgao_expeditor_ore',
    					   'cd_estado_est',
    					   'dt_expedicao_doc'];
    
    public function pessoa(){
    	return $this->hasOne('App\Models\Pessoa', 'cd_pessoa_pes', 'cd_pessoa_pes');
	}

    public function orgaoEmissor(){
        return $this->hasOne('App\Models\OrgaoEmissor', 'cd_orgao_expeditor_ore', 'cd_orgao_expeditor_ore');
    }

	public function estado()
    {
        return $this->hasOne(Estado::class, 'cd_estado_est', 'cd_estado_est');
    }	
}