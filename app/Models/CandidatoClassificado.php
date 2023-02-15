<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CandidatoClassificado extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_classificado_cac';
    protected $primaryKey = 'cd_opcao_candidato_opc';

    protected $fillable = ['cd_opcao_candidato_opc', 'cd_categoria_evento_cae', 'cd_evento_periodo_evp', 'nu_ordem_cac'];

    public $timestamps = false;

    public function opcao()
    {
        return $this->hasOne(OpcaoCandidato::class, 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc');
    }

    public function categoria() {
        return $this->hasOne(CategoriaEvento::class, 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }

    public function opcao1()
    {
        return $this->hasOne(Opcao::class, 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc')->where('nu_opcao_opc', \App\Enums\Opcao::OPCAO_1);
    }

    public function opcao1A()
    {
        return $this->hasOne(Opcao::class, 'cd_opcao_candidato_opc', 'cd_opcao_candidato_opc')->where('nu_opcao_opc', \App\Enums\Opcao::OPCAO_1A);
    }

    public function eventoPeriodo() {
        return $this->hasOne(EventoPeriodo::class, 'cd_evento_periodo_evp', 'cd_evento_periodo_evp');
    }

    public function getDadosDAE($evento, $instituicao, $curso, $categoria)
    {
      $where = "";

      if($instituicao){
        $where .= " AND t15.cd_instituicao_ies = ".$instituicao;
      }

      if($curso > 0){
        $where .= " AND t1.cd_curso_cur = ".$curso;
      }

      if($categoria){
        $where .= " AND t1.cd_categoria_cat = ".$categoria;
      }

      $sql = "SELECT t1.cd_curso_cur,
                  t1.cd_categoria_cat,
                  t1.nu_ordem_cac,
                  t1.cd_periodo_per,
                  t1.nu_opcao_opc,
                  t1.nu_inscricao_can,
                  t2.nm_candidato_can,
                  t2.nm_social_can,
                  t3.nm_mae_pes,
                  t3.dt_nascimento_pes,
                  t4.nm_sigla_sex,
                  t5.nm_documento_doc as cpf,
                  t6.nm_documento_doc as nu_identidade_can,
                  t12.sg_estado_est,
                  t11.nm_sigla_ore,
                  t1.nu_classificacao_opc,
                  t2.fl_ensino_publico_can,
                  t7.cd_raca_rac,
                  t8.nm_endereco_ene,
                  t9.nu_fone_fon,
                  t10.nm_logradouro_end,
                  t10.nm_bairro_end,
                  t10.nm_cidade_end,
                  t10.sg_estado_end,
                  t10.nu_cep_end,
                  t13.nm_estabelecimento_ensino_ese,
                  t2.nu_ano_segundo_grau_can,
                  t14.nu_acertos_ptg_pca,
                  t14.nu_acertos_lle_pca,
                  t14.nu_acertos_mtm_pca,
                  t14.nu_acertos_blg_pca,
                  t14.nu_acertos_fsc_pca,
                  t14.nu_acertos_qmc_pca,
                  t14.nu_acertos_chs_pca,
                  t14.nu_nota_redacao_pca,
                  t14.nu_nota_discursiva_1_pca,
                  t14.nu_nota_discursiva_2_pca,
                  t1.nu_nota_final_opc,
                  t16.cd_categoria_cat as categoria_inscricao,
                  t17.nm_curso_cur,
                  t17.cd_curso_cur,
                  t18.nm_campus_cam
            FROM
                processos_seletivos.candidato_classificado_vw t1
            JOIN processos_seletivos.candidato_can t2 ON t2.cd_evento_eve = t1.cd_evento_eve AND t2.cd_candidato_can = t1.cd_candidato_can
            JOIN pessoa.pessoa_pes t3 ON t3.cd_pessoa_pes = t2.cd_pessoa_pes
            JOIN pessoa.sexo_sex t4 ON t4.cd_sexo_sex = t3.cd_sexo_sex
            JOIN pessoa.documento_doc t5 ON t5.cd_pessoa_pes = t3.cd_pessoa_pes AND t5.cd_tipo_tpd = 1
            JOIN pessoa.documento_doc t6 ON t6.cd_pessoa_pes = t3.cd_pessoa_pes AND t6.cd_tipo_tpd = 2
            JOIN pessoa.raca_rac t7 ON t7.cd_raca_rac = t3.cd_raca_rac
            JOIN processos_seletivos.endereco_eletronico_ene t8 ON t8.cd_candidato_can = t2.cd_candidato_can
            JOIN processos_seletivos.fone_fon t9 ON t9.cd_candidato_can = t2.cd_candidato_can
            JOIN processos_seletivos.endereco_end t10 ON t10.cd_candidato_can = t2.cd_candidato_can
            JOIN pessoa.orgao_expeditor_ore t11 ON t11.cd_orgao_expeditor_ore = t6.cd_orgao_expeditor_ore
            JOIN concurso.estado_est t12 ON t12.cd_estado_est = t6.cd_estado_est
            LEFT JOIN processos_seletivos.estabelecimento_ensino_ese t13 ON t13.cd_estabelecimento_ensino_ese = t2.cd_estabelecimento_ensino_evento_eee
            JOIN processos_seletivos.ponto_candidato_acertos_pca t14 ON t14.cd_candidato_can = t2.cd_candidato_can
            JOIN processos_seletivos.instituicao_curso_vw t15 ON t15.cd_curso_evento_cue = t1.cd_curso_evento_cue
            JOIN processos_seletivos.categoria_evento_cae t16 ON t16.cd_categoria_evento_cae = t2.cd_categoria_evento_cae
            JOIN processos_seletivos.curso_cur t17 ON t17.cd_curso_cur = t1.cd_curso_cur
            JOIN processos_seletivos.campus_cam t18 ON t18.cd_campus_cam = t17.cd_campus_cam
            WHERE t1.cd_evento_eve = $evento
            $where
            ORDER BY t1.cd_curso_cur, cd_periodo_per, nu_ordem_cac";

      return DB::connection('pgsql')->select($sql);
    }

    public function getCursosClassificados($evento, $instituicao)
    {
      $whereInstituicao = "";
      if($instituicao != 9999)
        $whereInstituicao =  " and t2.cd_instituicao_ies = $instituicao";

      $sql = "SELECT t0.cd_curso_cur, t2.nm_abrev_curso_cur, t3.nm_campus_cam , t4.sg_instituicao_ies
                FROM processos_seletivos.candidato_classificado_vw t0
                join processos_seletivos.curso_cur t2 on t2.cd_curso_cur = t0.cd_curso_cur
                join processos_seletivos.campus_cam t3 on t2.cd_campus_cam = t3.cd_campus_cam
                join processos_seletivos.instituicao_ensino_superior_ies t4 on t2.cd_instituicao_ies = t4.cd_instituicao_ies $whereInstituicao
                where cd_evento_eve = $evento
                group by t0.cd_curso_cur, t2.nm_abrev_curso_cur, t3.nm_campus_cam , t4.sg_instituicao_ies
                order by t2.nm_abrev_curso_cur, t3.nm_campus_cam , t4.sg_instituicao_ies";

      return DB::connection('pgsql')->select($sql);
    }

    public function getClassificadosCurso($evento, $curso)
    {
      $sql = "SELECT t0.nu_inscricao_can, cd_periodo_per, nu_ordem_cac, cd_categoria_cat, nu_opcao_opc, cd_curso_cur,  coalesce(t1.nm_social_can, t1.nm_candidato_can) as nome
                FROM processos_seletivos.candidato_classificado_vw t0
                join processos_seletivos.candidato_can t1 on t0.cd_candidato_can = t1.cd_candidato_can and t0.cd_evento_eve = t1.cd_evento_eve
                where t1.cd_evento_eve = $evento and cd_curso_cur = $curso
                order by cd_periodo_per, nome";

      return DB::connection('pgsql')->select($sql);
    }


     public function getClassificadosCompleto($evento, $instituicao)
     {
      $whereInstituicao = "";
      if($instituicao != 9999)
        $whereInstituicao =  " and t2.cd_instituicao_ies = $instituicao";
      $sql = "SELECT t0.nu_inscricao_can, cd_periodo_per, nu_ordem_cac, cd_categoria_cat, nu_opcao_opc, t0.cd_curso_cur, t2.nm_abrev_curso_cur, t3.nm_campus_cam , t4.sg_instituicao_ies, coalesce(t1.nm_social_can, t1.nm_candidato_can) as nome
                FROM processos_seletivos.candidato_classificado_vw t0
                join processos_seletivos.candidato_can t1 on t0.cd_candidato_can = t1.cd_candidato_can and t0.cd_evento_eve = t1.cd_evento_eve
                join processos_seletivos.curso_cur t2 on t2.cd_curso_cur = t0.cd_curso_cur
                join processos_seletivos.campus_cam t3 on t2.cd_campus_cam = t3.cd_campus_cam
                join processos_seletivos.instituicao_ensino_superior_ies t4 on t2.cd_instituicao_ies = t4.cd_instituicao_ies $whereInstituicao
                where t1.cd_evento_eve = $evento
                order by t2.nm_abrev_curso_cur, t3.nm_campus_cam , t4.sg_instituicao_ies, cd_periodo_per, nome";

      return DB::connection('pgsql')->select($sql);
    }

    public function getNotaPrimeiroUltimo($evento, $categoria)
    {
      $sql = "select max(t0.nu_nota_final_opc) as max ,min(t0.nu_nota_final_opc) as min, t0.cd_curso_cur, t1.nm_abrev_curso_cur, t1.nm_campus_cam, t1.sg_instituicao_ies, t1.nu_vagas_originais_cuc, t1.nu_vagas_ocupadas_cuc
                from processos_seletivos.opcao_candidato_vw t0
                join processos_seletivos.candidato_classificado_vw t2 on t2.cd_evento_eve = t0.cd_evento_eve and t2.cd_opcao_candidato_opc = t0.cd_opcao_candidato_opc
                join processos_seletivos.instituicao_curso_categoria_vw t1 on t1.cd_curso_evento_cue = t0.cd_curso_evento_cue  and t1.cd_categoria_cat =t2.cd_categoria_cat
                where  t2.cd_categoria_cat = $categoria and t0.cd_indicador_ind =1 and t0.cd_evento_eve = $evento and t1.cd_categoria_cat =t2.cd_categoria_cat
                group by t0.cd_curso_cur, t1.nm_abrev_curso_cur, t1.nm_campus_cam, t1.sg_instituicao_ies, t1.nu_vagas_originais_cuc, t1.nu_vagas_ocupadas_cuc
                union
                select null as max, null as min, t0.cd_curso_cur, t0.nm_abrev_curso_cur, t6.nm_campus_cam, t2.sg_instituicao_ies, t3.nu_vagas_originais_cuc, t3.nu_vagas_ocupadas_cuc
                FROM processos_seletivos.curso_cur t0
     JOIN processos_seletivos.curso_evento_cue t1 ON t0.cd_curso_cur = t1.cd_curso_cur
     JOIN processos_seletivos.instituicao_ensino_superior_ies t2 ON t0.cd_instituicao_ies = t2.cd_instituicao_ies
     JOIN processos_seletivos.curso_categoria_cuc t3 ON t1.cd_curso_evento_cue = t3.cd_curso_evento_cue
     JOIN processos_seletivos.categoria_evento_cae t4 ON t3.cd_categoria_evento_cae = t4.cd_categoria_evento_cae
     JOIN processos_seletivos.categoria_cat t5 ON t4.cd_categoria_cat = t5.cd_categoria_cat
     JOIN processos_seletivos.campus_cam t6 ON t0.cd_campus_cam = t6.cd_campus_cam
     where  t3.nu_vagas_ocupadas_cuc = 0 and t5.cd_categoria_cat = $categoria and t1.cd_evento_eve = $evento
                group by t0.cd_curso_cur, t0.nm_abrev_curso_cur, t6.nm_campus_cam, t2.sg_instituicao_ies, t3.nu_vagas_originais_cuc, t3.nu_vagas_ocupadas_cuc
                order by 4";

      return DB::connection('pgsql')->select($sql);
    }

    public function getPrimeirosClassificados($evento, $instituicao, $limit)
    {
      $whereInstituicao = "";
      if($instituicao != 9999)
        $whereInstituicao =  " and t4.cd_instituicao_ies = $instituicao";

      $sql = "select coalesce(t2.nm_social_can, t2.nm_candidato_can) as nm_candidato_can, t4.cd_curso_cur, t4.nm_abrev_curso_cur, t4.nm_campus_cam, t4.sg_instituicao_ies, (t1.nu_acertos_ptg_pca+t1.nu_acertos_lle_pca+t1.nu_acertos_mtm_pca+t1.nu_acertos_blg_pca+t1.nu_acertos_chs_pca+t1.nu_acertos_fsc_pca+t1.nu_acertos_qmc_pca+t1.nu_nota_redacao_pca+t1.nu_nota_discursiva_1_pca+t1.nu_nota_discursiva_2_pca) as pontos, t5.nm_cidade_end, t5.sg_estado_end
from processos_seletivos.ponto_candidato_acertos_pca t1
join processos_seletivos.candidato_can t2 on (t1.cd_candidato_can = t2.cd_candidato_can)
join processos_seletivos.opcao_candidato_opc t3 on (t1.cd_candidato_can = t3.cd_candidato_can and t3.nu_opcao_opc = '1')
join processos_seletivos.instituicao_curso_vw t4 on (t4.cd_curso_evento_cue = t3.cd_curso_evento_cue) $whereInstituicao
join processos_seletivos.endereco_end t5 on t5.cd_candidato_can = t1.cd_candidato_can
where t1.nu_nota_redacao_pca is not null
and t1.nu_nota_discursiva_1_pca is not null
and t1.nu_nota_discursiva_2_pca is not null
and t2.fl_cancelado_can = false
and t2.cd_evento_eve = $evento
order by 6 desc limit $limit";

      return DB::connection('pgsql')->select($sql);
    }

    public function getPrimeirosClassificadosEscolaPublica($evento, $instituicao, $limit)
    {
      $whereInstituicao = "";
      if($instituicao != 9999)
        $whereInstituicao =  " and t4.cd_instituicao_ies = $instituicao";

      $sql = "select coalesce(t2.nm_social_can, t2.nm_candidato_can) as nm_candidato_can, t4.cd_curso_cur, t4.nm_abrev_curso_cur, t4.nm_campus_cam, t4.sg_instituicao_ies, t8.nm_estabelecimento_ensino_ese, t6.cd_categoria_cat, (t1.nu_acertos_ptg_pca+t1.nu_acertos_lle_pca+t1.nu_acertos_mtm_pca+t1.nu_acertos_blg_pca+t1.nu_acertos_chs_pca+t1.nu_acertos_fsc_pca+t1.nu_acertos_qmc_pca+t1.nu_nota_redacao_pca+t1.nu_nota_discursiva_1_pca+t1.nu_nota_discursiva_2_pca) as pontos, t5.nm_cidade_end, t5.sg_estado_end
from processos_seletivos.ponto_candidato_acertos_pca t1
join processos_seletivos.candidato_can t2 on (t1.cd_candidato_can = t2.cd_candidato_can)
join processos_seletivos.opcao_candidato_opc t3 on (t1.cd_candidato_can = t3.cd_candidato_can and t3.nu_opcao_opc = '1')
join processos_seletivos.instituicao_curso_vw t4 on (t4.cd_curso_evento_cue = t3.cd_curso_evento_cue) $whereInstituicao
join processos_seletivos.endereco_end t5 on t5.cd_candidato_can = t1.cd_candidato_can
join processos_seletivos.candidato_classificado_vw t6 on t6.cd_candidato_can = t1.cd_candidato_can and t6.cd_categoria_cat != 3
join processos_seletivos.estabelecimento_ensino_evento_eee t7 on t7.cd_estabelecimento_ensino_evento_eee = t2.cd_estabelecimento_ensino_evento_eee
join processos_seletivos.estabelecimento_ensino_ese t8 on t8.cd_estabelecimento_ensino_ese = t7.cd_estabelecimento_ensino_ese
where t1.nu_nota_redacao_pca is not null
and t1.nu_nota_discursiva_1_pca is not null
and t1.nu_nota_discursiva_2_pca is not null
and t2.fl_cancelado_can = false
and t2.cd_evento_eve = $evento and t2.cd_evento_eve = t7.cd_evento_eve
order by 8 desc limit $limit";

      return DB::connection('pgsql')->select($sql);
    }

    public function getEstatisticasPorEscola($evento)
    {
      $sql = "select
                t1.nm_estabelecimento_ensino_ese,
                t2.nm_municipio_mun,
                count(*) as inscritos,
                count(case when t4.cd_candidato_can is not null then 1 else null end) as classificados
            from
                processos_seletivos.estabelecimento_ensino_evento_eee t0
                join processos_seletivos.estabelecimento_ensino_ese t1 on t0.cd_estabelecimento_ensino_ese = t1.cd_estabelecimento_ensino_ese
                inner join util.municipio_mun t2 on (t1.cd_municipio_mun = t2.cd_municipio_mun)
                join processos_seletivos.candidato_can t3 on (t0.cd_estabelecimento_ensino_evento_eee = t3.cd_estabelecimento_ensino_evento_eee and t0.cd_evento_eve = t3.cd_evento_eve)
                left join processos_seletivos.candidato_classificado_vw t4 on (t3.cd_candidato_can = t4.cd_candidato_can and t3.cd_evento_eve = t4.cd_evento_eve)
            where
                t0.cd_evento_eve = 101
                and
                t3.fl_cancelado_can = false
                and
                t3.fl_homologado_can = true
                and
                t3.fl_experiencia_can = false
                and
                t3.deleted_at is null

            group by
                t1.nm_estabelecimento_ensino_ese,
                t2.nm_municipio_mun
            order by nm_municipio_mun,nm_estabelecimento_ensino_ese";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalInscritos($evento)
    {
      $sql = "select count(*) as total
                    from
                        processos_seletivos.candidato_can t0
                        inner join processos_seletivos.estabelecimento_ensino_evento_eee t1 on (t0.cd_estabelecimento_ensino_evento_eee = t1.cd_estabelecimento_ensino_evento_eee and t0.cd_evento_eve = t1.cd_evento_eve)
                    where
                        t0.cd_evento_eve = 101
                    and
                    t0.fl_cancelado_can = false
                    and
                    t0.fl_homologado_can = true
                    and
                    t0.fl_experiencia_can = false
                    and
                    t0.deleted_at is null
                        ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalClassificados($evento)
    {
      $sql = "select count(*) as total
                    from
                        processos_seletivos.candidato_can t0
                        inner join processos_seletivos.estabelecimento_ensino_evento_eee t1 on (t0.cd_estabelecimento_ensino_evento_eee = t1.cd_estabelecimento_ensino_evento_eee and t0.cd_evento_eve = t1.cd_evento_eve)
                        join processos_seletivos.candidato_classificado_vw t2 on t0.cd_candidato_can = t2.cd_candidato_can and t0.cd_evento_eve =t2.cd_evento_eve
                    where
                        t0.cd_evento_eve = 101
                    and
                    t0.fl_cancelado_can = false
                    and
                    t0.fl_homologado_can = true
                    and
                    t0.fl_experiencia_can = false
                    and
                    t0.deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalPorExperiencia($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                    where t1.cd_evento_eve = $evento
                    and t1.fl_experiencia_can = true
                    and t1.fl_homologado_can = true
                    and t1.fl_cancelado_can = false
                    and t1.deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalConcorrentes($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                    where t1.cd_evento_eve = $evento
                    and t1.fl_experiencia_can = false
                    and t1.fl_homologado_can = true
                    and t1.fl_cancelado_can = false
                    and t1.deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalAbstencaoDia1($evento)
    {
      $sql = "select round(100.00*count(*)/(select count(*) from processos_seletivos.candidato_can
                where cd_evento_eve = $evento
                and fl_homologado_can = true),2) as total
                from processos_seletivos.candidato_can t1
                join processos_seletivos.cartao_resposta_car t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_prova_pro = 1)
                where t1.cd_evento_eve = $evento
                and t1.fl_cancelado_can = false
                and t2.fl_faltante_car = true
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalAbstencaoDia2($evento)
    {
      $sql = "select round(100.00*count(*)/(select count(*) from processos_seletivos.candidato_can
                where cd_evento_eve = $evento
                and fl_homologado_can = true),2) as total
                from processos_seletivos.candidato_can t1
                join processos_seletivos.cartao_resposta_car t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_prova_pro = 2)
                where t1.cd_evento_eve = $evento
                and t1.fl_cancelado_can = false
                and t2.fl_faltante_car = true
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalAbstencaoGeral($evento)
    {
      $sql = "select round(100.00*count(*)/(select count(*) from processos_seletivos.candidato_can
                where cd_evento_eve = $evento
                and fl_homologado_can = true),2) as total
                from processos_seletivos.candidato_can t1
                join processos_seletivos.cartao_resposta_car t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_prova_pro = 1)
                join processos_seletivos.cartao_resposta_car t3 on (t1.cd_candidato_can = t3.cd_candidato_can and t3.cd_prova_pro = 2)
                where t1.cd_evento_eve = $evento
                and t1.fl_cancelado_can = false
                and (t2.fl_faltante_car = true or t3.fl_faltante_car = true)
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalAprovados($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1')
                full outer join processos_seletivos.opcao_candidato_opc t3 on (t1.cd_candidato_can = t3.cd_candidato_can and t3.nu_opcao_opc = '1A')
                join processos_seletivos.curso_evento_cue t4 on t4.cd_curso_evento_cue = t2.cd_curso_evento_cue
                where t1.cd_evento_eve = $evento
                and t1.fl_cancelado_can is not true
                and t1.fl_homologado_can is true
                and t4.cd_curso_cur != 999
                and ( (t2.cd_indicador_ind = 2 and t3.cd_indicador_ind is null) or -- Não classificado na opção 1 em curso sem opção 1A
                      (t2.cd_indicador_ind = 2 and t3.cd_indicador_ind != 1) or    -- Não classificado na opção 1 e não classificado ou reprovado na 1A
                      (t2.cd_indicador_ind != 1 and t3.cd_indicador_ind = 2) )  -- Não classificado  ou reprovado na opção 1 e não classificado na 1A
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalReprovados($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1')
                full outer join processos_seletivos.opcao_candidato_opc t3 on (t1.cd_candidato_can = t3.cd_candidato_can and t3.nu_opcao_opc = '1A')
                join processos_seletivos.curso_evento_cue t4 on t4.cd_curso_evento_cue = t2.cd_curso_evento_cue
                where t1.cd_evento_eve = $evento
                and t1.fl_cancelado_can is not true
                and t1.fl_homologado_can is true
                and t1.deleted_at is null
                and t4.cd_curso_cur != 999
                and ( (t2.cd_indicador_ind = 3 and t3.cd_indicador_ind is null ) or -- Reprovado na 1a opção em curso sem opção 1A
                      (t2.cd_indicador_ind = 3 and t3.cd_indicador_ind = 3) ) -- Reprovado na 1a opção e na opção 1A
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalReprovadosFalta($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1')
                join processos_seletivos.curso_evento_cue t3 on t3.cd_curso_evento_cue = t2.cd_curso_evento_cue
                where t1.cd_evento_eve = $evento
                and t1.fl_homologado_can = true
                and t1.fl_cancelado_can is not true
                and t2.cd_ocorrencia_opcao_oco = 3
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalReprovadosCorteOpcao1($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1')
                join processos_seletivos.curso_evento_cue t3 on t3.cd_curso_evento_cue = t2.cd_curso_evento_cue
                where t1.cd_evento_eve = $evento
                and t1.fl_homologado_can = true
                and t1.fl_cancelado_can is not true
                and t2.cd_ocorrencia_opcao_oco = 4
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalReprovadosCorteOpcao1A($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1A')
                join processos_seletivos.curso_evento_cue t3 on t3.cd_curso_evento_cue = t2.cd_curso_evento_cue
                where t1.cd_evento_eve = $evento
                and t1.fl_homologado_can = true
                and t1.fl_cancelado_can is not true
                and t2.cd_ocorrencia_opcao_oco = 4
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalReprovadosRedacao($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1')
                join processos_seletivos.curso_evento_cue t3 on t3.cd_curso_evento_cue = t2.cd_curso_evento_cue
                where t1.cd_evento_eve = $evento
                and t1.fl_homologado_can = true
                and t1.fl_cancelado_can is not true
                and t2.cd_ocorrencia_opcao_oco in (7,9)
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalVagasOferecidas($evento)
    {
      $sql = "select sum(nu_vagas_cue) as total from processos_seletivos.curso_evento_cue
                where cd_evento_eve = $evento and deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalVagasOcupadasOpcao1($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1')
                where cd_evento_eve = $evento
                and t2.cd_indicador_ind = 1 and t1.deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalVagasOcupadasOpcao1A($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on (t1.cd_candidato_can = t2.cd_candidato_can and t2.nu_opcao_opc = '1A')
                where cd_evento_eve = $evento
                and t2.cd_indicador_ind = 1 and t1.deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalVagasOcupadasTotal($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_classificado_vw
                where cd_evento_eve = $evento
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalIsencoesRequeridas($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.isentos_ise
                where cd_evento_eve = $evento and deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalIsencoesConcedidas($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.isentos_ise
                where cd_evento_eve = $evento
                and fl_deferimento_ise = true
                and deleted_at is null
             ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalIsentosClassificados($evento)
    {
      $sql = "select count(*) as total from processos_seletivos.candidato_can t1
                join processos_seletivos.opcao_candidato_opc t2 on t1.cd_candidato_can = t2.cd_candidato_can
                where cd_evento_eve = $evento
                and fl_homologado_can = true
                and fl_cancelado_can is not true
                and t2.cd_indicador_ind = 1
                and cd_tipo_homologacao_candidato_thc in (2,3) -- isento ou apenado
             ";

      return DB::connection('pgsql')->select($sql);
    }

}
