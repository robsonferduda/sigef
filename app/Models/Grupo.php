<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.grupo_gru';
	protected $primaryKey = 'cd_grupo_gru';

    protected $fillable = ['fl_condicao_gru']; 

    public $timestamps = false;

    public function setorEvento()
    {
        return $this->belongsTo('App\Models\SetorEvento', 'cd_setor_evento_see', 'cd_setor_evento_see');
    }

    public function getDadosGrupo($grupo)
    {
      $sql = "SELECT nu_carteiras_disponiveis_gru, nu_carteiras_ocupadas_gru, (nu_carteiras_disponiveis_gru - nu_carteiras_ocupadas_gru) as nu_carteiras_livres
                FROM processos_seletivos.grupo_gru t1,
                    processos_seletivos.setor_evento_see t2
                WHERE t1.cd_setor_evento_see = t2.cd_setor_evento_see 
                AND t2.cd_evento_eve = 101
                AND cd_grupo_gru = $grupo";

      return DB::connection('pgsql')->select($sql);
    }

    public function getDadosGrupoCodigo($cd_unico,$setor_evento)
    {
      $sql = "SELECT cd_grupo_gru
                FROM processos_seletivos.grupo_gru t1,
                    processos_seletivos.setor_evento_see t2
                WHERE t1.cd_setor_evento_see = t2.cd_setor_evento_see 
                AND t2.cd_evento_eve = 101
                AND t1.cd_setor_evento_see = $setor_evento
                AND nu_grupo_gru = $cd_unico";

      return DB::connection('pgsql')->select($sql)[0]->cd_grupo_gru;
    }
}
