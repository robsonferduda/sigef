<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CandidatoEsperaFinal extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_espera_final_cef';
    protected $primaryKey = 'cd_opcao_candidato_opc';

    protected $fillable = ['cd_opcao_candidato_opc', 'cd_categoria_evento_cae', 'nu_ordem_cef'];

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
                t1.nu_ordem_cef,
                '' as cd_periodo_per, 
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
                processos_seletivos.candidato_espera_final_vw t1
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
            ORDER BY t1.cd_curso_cur, cd_periodo_per, nu_ordem_cef";

      return DB::connection('pgsql')->select($sql);
    }

}