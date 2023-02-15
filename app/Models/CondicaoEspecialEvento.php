<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CondicaoEspecialEvento extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.condicao_especial_evento_cee';
	protected $primaryKey = 'cd_condicao_especial_evento_cee';

    protected $fillable = [
                            'cd_condicao_especial_coe',
                            'cd_evento_eve',
                            'fl_junta_medica_cee',
                            'fl_laudo_cee'
                        ]; //whitelist de inserção

    public $timestamps = false;

    public function condicao()
    {
        return $this->hasOne(CondicaoEspecial::class, 'cd_condicao_especial_coe','cd_condicao_especial_coe');
    }

    public function getTotalCondicoes()
    {
      $sql = "SELECT t4.nm_condicao_especial_coe, 
                     COUNT(*) as total,
                     COUNT(t1.cd_candidato_can) filter (WHERE t1.cd_ordem_can is not null) as alocados,
                     COUNT(t1.cd_candidato_can) filter (WHERE t1.cd_ordem_can is null) as nao_alocados
                FROM processos_seletivos.candidato_can t1,
                    processos_seletivos.candidato_condicao_especial_cce t2,
                    processos_seletivos.condicao_especial_evento_cee t3,
                    processos_seletivos.condicao_especial_coe t4,
                    processos_seletivos.local_prova_evento_lpe t5,
                    processos_seletivos.local_prova_lop t6
                WHERE t1.cd_candidato_can = t2.cd_candidato_can 
                AND t2.cd_condicao_especial_evento_cee = t3.cd_condicao_especial_evento_cee 
                AND t3.cd_condicao_especial_coe = t4.cd_condicao_especial_coe 
                AND t1.cd_local_prova_evento_lpe = t5.cd_local_prova_evento_lpe 
                AND t6.cd_local_prova_lop = t5.cd_local_prova_lop 
                AND t1.cd_evento_eve = 101
                AND t2.cd_situacao_condicao_especial_sce IN(2,4)
                GROUP BY t4.nm_condicao_especial_coe 
                ORDER BY t4.nm_condicao_especial_coe ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalCondicoesLocal()
    {
      $sql = "SELECT t6.nm_local_prova_lop, t4.nm_condicao_especial_coe, 
                    COUNT(*) as total,
                    COUNT(t1.cd_candidato_can) filter (WHERE t1.cd_ordem_can is not null) as alocados,
                    COUNT(t1.cd_candidato_can) filter (WHERE t1.cd_ordem_can is null) as nao_alocados 
                FROM processos_seletivos.candidato_can t1,
                    processos_seletivos.candidato_condicao_especial_cce t2,
                    processos_seletivos.condicao_especial_evento_cee t3,
                    processos_seletivos.condicao_especial_coe t4,
                    processos_seletivos.local_prova_evento_lpe t5,
                    processos_seletivos.local_prova_lop t6
                WHERE t1.cd_candidato_can = t2.cd_candidato_can 
                AND t2.cd_condicao_especial_evento_cee = t3.cd_condicao_especial_evento_cee 
                AND t3.cd_condicao_especial_coe = t4.cd_condicao_especial_coe 
                AND t1.cd_local_prova_evento_lpe = t5.cd_local_prova_evento_lpe 
                AND t6.cd_local_prova_lop = t5.cd_local_prova_lop 
                AND t1.cd_evento_eve = 101
                AND t2.cd_situacao_condicao_especial_sce IN(2,4)
                GROUP BY t6.nm_local_prova_lop, t4.nm_condicao_especial_coe 
                ORDER BY t6.nm_local_prova_lop, t4.nm_condicao_especial_coe ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getCandidatosCondicaoEvento($lista, $local, $condicao)
    {
        $sql = "SELECT t7.cd_curso_evento_cue, t9.nm_curso_cur, t1.cd_candidato_can, t1.nu_inscricao_can, t1.nm_candidato_can, 0 as nu_grupo_gru, t1.cd_grupo_gru, t1.cd_ordem_can 
                    FROM processos_seletivos.candidato_can t1,
                        processos_seletivos.candidato_condicao_especial_cce t2,
                        processos_seletivos.condicao_especial_evento_cee t3,
                        processos_seletivos.condicao_especial_coe t4,
                        processos_seletivos.local_prova_evento_lpe t5,
                        processos_seletivos.local_prova_lop t6,
                        processos_seletivos.opcao_candidato_opc t7,
                        processos_seletivos.curso_evento_cue t8,
                        processos_seletivos.curso_cur t9
                    WHERE t1.cd_candidato_can = t2.cd_candidato_can 
                    AND t2.cd_condicao_especial_evento_cee = t3.cd_condicao_especial_evento_cee 
                    AND t3.cd_condicao_especial_coe = t4.cd_condicao_especial_coe 
                    AND t1.cd_local_prova_evento_lpe = t5.cd_local_prova_evento_lpe 
                    AND t6.cd_local_prova_lop = t5.cd_local_prova_lop 
                    AND t7.cd_candidato_can = t1.cd_candidato_can 
                    AND t7.nu_opcao_opc = '1'
                    AND t7.cd_curso_evento_cue = t8.cd_curso_evento_cue 
                    AND t8.cd_curso_cur = t9.cd_curso_cur
                    AND t1.cd_evento_eve = 101
                    AND t2.cd_situacao_condicao_especial_sce IN(2,4)
                    AND t1.cd_local_prova_evento_lpe = $local
                    AND t2.cd_condicao_especial_evento_cee = $condicao";

        if($lista == "pendentes") $sql .= "AND t1.cd_ordem_can IS NULL ";
        if($lista == "alocados") $sql .= "AND t1.cd_ordem_can IS NOT NULL ";

        $sql .= "ORDER BY t1.nm_candidato_can";                    

      return DB::connection('pgsql')->select($sql);
    }
}