<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Relatorio extends Model 
{    
    
    protected $connection = 'pgsql';

    public function buscaProvasLocalSetorGrupoCorProvaGrafica($evento,$setor,$local){
        $sql = "SELECT distinct 1 as tipo,
                    t7.cd_local_prova_lop,
                    t7.nm_local_prova_lop,
                    t5.cd_setor_sel,
                    t5.cd_unico_sel,
                    t5.nm_setor_sel,
                    t1.cd_grupo_gru,
                    t8.nu_grupo_gru,
                    1 as grupo_total
                FROM 
                    processos_seletivos.candidato_can t1
                join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                join processos_seletivos.grupo_gru t8 on t8.cd_grupo_gru = t1.cd_grupo_gru
                WHERE 
                    t1.cd_evento_eve = $evento
					and t1.fl_homologado_can = true ";

			if(!empty($local))
				$sql .= " and t6.cd_local_prova_evento_lpe = $local";
			if(!empty($setor))
				$sql .= " and t4.cd_setor_evento_see = $setor ";

			$sql .= "UNION ALL SELECT distinct 2 as tipo,
                    t7.cd_local_prova_lop,
                    t7.nm_local_prova_lop,
                    t5.cd_setor_sel,
                    t5.cd_unico_sel,
                    t5.nm_setor_sel,
                    0,
                    0,
                    1 as grupo_total
                FROM 
                    processos_seletivos.candidato_can t1
                join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                WHERE 
                    t1.cd_evento_eve = $evento
					and t1.fl_homologado_can = true ";

			if(!empty($local))
				$sql .= " and t6.cd_local_prova_evento_lpe = $local";
			if(!empty($setor))
				$sql .= " and t4.cd_setor_evento_see = $setor ";


            $sql .= "ORDER BY 
                       2,
                       5,
                       1,
                       8";   

        return DB::connection('pgsql')->select($sql);

    } 

    public function buscaQtdPorCorProva($evento,$local,$setor,$grupo,$prova,$tipoProva){
    	$sql = "SELECT count(*) as qtd
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova and t3.nu_tipo_tip = $tipoProva
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                    WHERE 
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true 
                        and t6.cd_local_prova_lop = $local
                        and t5.cd_setor_sel = $setor 
                        and t1.cd_grupo_gru = $grupo";


       	return DB::connection('pgsql')->select($sql)[0]->qtd;
    }

    public function buscaQtdProva($evento,$local,$setor,$grupo){
        $sql = "SELECT count(*) as qtd
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                    WHERE 
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true 
                        and t6.cd_local_prova_lop = $local
                        and t5.cd_setor_sel = $setor 
                        and t1.cd_grupo_gru = $grupo";


        return DB::connection('pgsql')->select($sql)[0]->qtd;
    }

    public function buscaQtdProvaParaReserva($evento,$local,$setor){
        $sql = "SELECT count(*) as qtd
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                    WHERE 
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true 
                        and t6.cd_local_prova_lop = $local
                        and t5.cd_setor_sel = $setor";


        return DB::connection('pgsql')->select($sql)[0]->qtd;
    }

    public function buscaQtdPorCorProvaReserva($evento,$local,$setor,$prova,$tipoProva,$percentual){

    	$sql = "SELECT round(count(*) * $percentual) as qtd
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova and t3.nu_tipo_tip = $tipoProva
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                    WHERE 
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true 
                        and t6.cd_local_prova_lop = $local
                        and t5.cd_setor_sel = $setor
    	";

    	return DB::connection('pgsql')->select($sql)[0]->qtd;
    }

    public function buscaQtdComCorProvaReserva($evento,$local,$setor,$prova, $tipoProva, $percentual){

        $sql = "SELECT round(count(*) * $percentual) as qtd, t3.nm_tipo_tip
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova and t3.nu_tipo_tip = $tipoProva
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                    WHERE 
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true 
                        and t6.cd_local_prova_lop = $local
                        and t5.cd_setor_sel = $setor
                        group by  t3.nm_tipo_tip";

        $res = DB::connection('pgsql')->select($sql);
        if($res)
            return $res[0];
        else
            return false;
        
    }

    public function buscaQtdProvaReserva($evento,$local,$setor,$percentual){

        $sql = "SELECT round(count(*) * $percentual) as qtd
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see 
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel 
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe 
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop 
                    WHERE 
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true 
                        and t6.cd_local_prova_lop = $local
                        and t5.cd_setor_sel = $setor
        ";

        return DB::connection('pgsql')->select($sql)[0]->qtd;
    }

}