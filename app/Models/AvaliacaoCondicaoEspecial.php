<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AvaliacaoCondicaoEspecial extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.avaliacao_condicao_especial_ace';
    protected $primaryKey = 'cd_avaliacao_condicao_especial_ace';

    protected $fillable = ['cd_candidato_can',
                            'cd_candidato_condicao_especial_cce',  
                            'cd_motivo_indeferimento_condicao_especial_mic', 
                            'cd_situacao_condicao_especial_sce', 
                            'cd_usuario_usu',
                            'ds_complemento_ace'
                        ];

    public function pedido()
    {
        return $this->hasOne(CandidatoCondicaoEspecial::class, 'cd_candidato_condicao_especial_cce', 'cd_candidato_condicao_especial_cce');
    }

    public function situacao()
    {
        return $this->hasOne(SituacaoCondicaoEspecial::class, 'cd_situacao_condicao_especial_sce', 'cd_situacao_condicao_especial_sce');
    }

    public function motivoIndeferimento()
    {
        return $this->hasOne(MotivoIndeferimentoCondicaoEspecial::class, 'cd_motivo_indeferimento_condicao_especial_mic', 'cd_motivo_indeferimento_condicao_especial_mic');
    }

    public function usuario()
    {
        return $this->hasOne('App\User', 'id', 'cd_usuario_usu');
    } 

    public function getPedidosPendentesAvaliacao($usuario)
    {
      //Retorna o id de isento que ainda não possui as duas avaliações válidas
      $sql = "SELECT DISTINCT t1.cd_candidato_can as candidato
                FROM processos_seletivos.candidato_condicao_especial_cce t1
                JOIN processos_seletivos.candidato_can t2 ON t1.cd_candidato_can = t2.cd_candidato_can 
                JOIN processos_seletivos.condicao_especial_evento_cee t3 ON t1.cd_condicao_especial_evento_cee = t3.cd_condicao_especial_evento_cee 
                WHERE t2.cd_evento_eve = 101
                AND t2.fl_homologado_can = true
                AND t3.fl_junta_medica_cee = true
                AND t1.cd_candidato_can NOT IN(SELECT cd_candidato_can 
                                                                FROM processos_seletivos.avaliacao_condicao_especial_ace 
                                                                WHERE cd_usuario_usu != $usuario
                                                                GROUP BY cd_candidato_can
                                                                HAVING count(*) < 2)";

        return DB::connection('pgsql')->select($sql)[0]->candidato;
    }  
}