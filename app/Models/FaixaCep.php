<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class FaixaCep extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.faixa_cep_fac';
	protected $primaryKey = 'id_faixa_cep_fac';

    protected $fillable = [];

    public $timestamps = false;

    public function getTotalFaixas()
    {
      $sql = "SELECT t3.nm_faixa_fac, t3.nu_cep_inicial_fac, t3.nu_cep_final_fac, t3.fl_alocacao_fac, 
              COUNT(*) AS total,
              COUNT(t1.cd_candidato_can) filter (where t4.fl_canhoto_pes = 'N') as destros,
              COUNT(t1.cd_candidato_can) filter (where t4.fl_canhoto_pes = 'S') as canhotos
                        FROM processos_seletivos.candidato_can t1,
                            processos_seletivos.endereco_end t2,
                            processos_seletivos.faixa_cep_fac t3,
                            pessoa.pessoa_pes t4
                        WHERE t1.cd_evento_eve = t2.cd_evento_eve
                        AND   t1.cd_candidato_can = t2.cd_candidato_can
                        AND   t1.cd_evento_eve = t3.cd_evento_eve
                        AND   t2.cd_evento_eve = t3.cd_evento_eve
                        AND   t1.cd_pessoa_pes = t4.cd_pessoa_pes
                        AND t1.cd_evento_eve = 101
                        AND t1.cd_local_prova_evento_lpe = 7
                        AND t1.fl_homologado_can is true
                        AND t1.fl_sabatista_can = false
                        AND t1.fl_apenado_can = false
                        AND t1.fl_prova_libras_can = false
                        AND t1.cd_lingua_evento_lie != 6
                        AND t2.nu_cep_end between t3.nu_cep_inicial_fac AND t3.nu_cep_final_fac
                        GROUP BY t3.nm_faixa_fac, t3.nu_cep_inicial_fac, t3.nu_cep_final_fac, t3.fl_alocacao_fac
                        ORDER BY t3.nu_cep_inicial_fac, t3.nm_faixa_fac";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalExternosSC()
    {
      $sql = "SELECT count(*) as total
                FROM processos_seletivos.candidato_can t1,
                    processos_seletivos.endereco_end t2,
                    pessoa.pessoa_pes t4
                WHERE t1.cd_evento_eve = t2.cd_evento_eve
                AND   t1.cd_candidato_can = t2.cd_candidato_can
                AND   t1.cd_pessoa_pes = t4.cd_pessoa_pes
                AND t1.cd_evento_eve = 101
                AND t1.cd_local_prova_evento_lpe = 7
                AND t1.fl_homologado_can is true
                AND t1.fl_sabatista_can = false
                AND t1.fl_apenado_can = false
                AND t2.nu_cep_end not between 88000000 AND 89999999";

      return DB::connection('pgsql')->select($sql)[0]->total;
    }
}