<?php

namespace App\Models;

use App\Enums\TipoFone;
use DB;
use App\Enums\Opcao;
use App\Enums\TipoAnexo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidato extends Model
{
    use SoftDeletes;

    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.candidato_can';
	protected $primaryKey = 'cd_candidato_can';

    protected $fillable = ['cd_evento_eve',
                            'cd_candidato_can',
                            'cd_pessoa_pes',
                            'nu_inscricao_can',
                            'nu_mes_segundo_grau_can',
                            'nu_ano_segundo_grau_can',
                            'nm_candidato_can',
                            'nm_social_can',
                            'cd_raca_rac',
                            'cd_categoria_evento_cae',
                            'cd_condicao_auditiva_coa',
                            'cd_motivo_cancelamento_moc',
                            'fl_apenado_can',
                            'fl_sabatista_can',
                            'fl_homologado_can',
                            'fl_experiencia_can',
                            'fl_cancelado_can',
                            'fl_prova_libras_can',
                            'fl_ensino_publico_can',
                            'fl_paa_can',
                            'fl_portador_deficiencia_can',
                            'fl_condicao_especial_can',
                            'cd_estabelecimento_ensino_evento_eee',
                            'cd_setor_evento_see',
                            'cd_grupo_gru',
                            'cd_ordem_can',
                            'cd_lingua_evento_lie',
                            'cd_local_prova_evento_lpe',
                            'sg_estado_estabelecimento_ensino_can',
                            'cd_municipio_estabelecimento_ensino_can',
                            'cd_tipo_homologacao_candidato_thc',
                            'dt_inscricao_homologada_can'];

    public function categoria()
    {
        return $this->hasOne(CategoriaEvento::class, 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }

    public function eventoCategoria(){
        return $this->hasOne('App\Models\EventoCategoria','cd_categoria_evento_cae','cd_categoria_evento_cae');
    }

    public function estabelecimentoEvento()
    {
        return $this->hasOne('App\Models\EstabelecimentoEnsinoEvento', 'cd_estabelecimento_ensino_evento_eee', 'cd_estabelecimento_ensino_evento_eee');
    }

    public function celular()
    {
        return $this->hasOne(Fone::class, 'cd_candidato_can', 'cd_candidato_can')->where('cd_tipo_tif', TipoFone::CELULAR);
    }

    public function email()
    {
        return $this->hasOne(EnderecoEletronico::class, 'cd_candidato_can', 'cd_candidato_can')->where('fl_principal_ene', TRUE);
    }

    public function localEvento(){
        return $this->hasOne('App\Models\LocalEvento','cd_local_prova_evento_lpe','cd_local_prova_evento_lpe');
    }

    public function setorEvento(){
        return $this->hasOne('App\Models\SetorEvento','cd_setor_evento_see','cd_setor_evento_see');
    }

    public function condicoes()
    {
        return $this->hasMany(CandidatoCondicaoEspecial::class, 'cd_candidato_can', 'cd_candidato_can');
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'cd_candidato_can', 'cd_candidato_can');
    }

    public function anexosCondicao()
    {
        return $this->hasMany(Anexo::class, 'cd_candidato_can', 'cd_candidato_can')->where('cd_tipo_anexo_tia', TipoAnexo::CONDICAO);
    }

    public function anexosIsencao()
    {
        return $this->hasMany(Anexo::class, 'cd_candidato_can', 'cd_candidato_can')->where('cd_tipo_anexo_tia', TipoAnexo::LEI);
    }

    public function pagamento()
    {
        return $this->hasMany(Pagamento::class, 'cd_candidato_can', 'cd_candidato_can');
    }

    public function opcao(){
        return $this->hasOne('App\Models\OpcaoCandidato','cd_candidato_can','cd_candidato_can');
    }

    public function opcao1()
    {
        return $this->hasOne(OpcaoCandidato::class, 'cd_candidato_can', 'cd_candidato_can')->where('nu_opcao_opc', Opcao::OPCAO_1);
    }

    public function opcao1A()
    {
        return $this->hasOne(OpcaoCandidato::class, 'cd_candidato_can', 'cd_candidato_can')->where('nu_opcao_opc', Opcao::OPCAO_1A);
    }

    public function grupo(){
        return $this->hasOne('App\Models\Grupo','cd_grupo_gru','cd_grupo_gru');
    }

    public function pessoa(){
        return $this->hasOne('App\Models\Pessoa', 'cd_pessoa_pes', 'cd_pessoa_pes');
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'cd_candidato_can', 'cd_candidato_can')->where('fl_principal_end', 'S');
    }

    public function enderecoEletronico(){
        return $this->hasMany('App\Models\EnderecoEletronico', 'cd_candidato_can', 'cd_candidato_can');
    }

    public function enderecoEletronicoPrincipal(){
        return $this->hasOne('App\Models\EnderecoEletronico', 'cd_candidato_can', 'cd_candidato_can')->where('fl_principal_ene', true);
    }

    public function telefonePrincipal(){
        return $this->hasOne('App\Models\Fone', 'cd_candidato_can', 'cd_candidato_can')->where('fl_principal_fon','S');
    }

    public function telefoneSecundario(){
        return $this->hasOne('App\Models\Fone', 'cd_candidato_can', 'cd_candidato_can')->where('fl_principal_fon','N');
    }

    public function linguaEvento()
    {
        return $this->hasOne('App\Models\LinguaEvento', 'cd_lingua_evento_lie', 'cd_lingua_evento_lie');
    }

    public function candidatoTipoProva()
    {
        return $this->hasMany('App\Models\CandidatoTipoProva', 'cd_candidato_can', 'cd_candidato_can');
    }

    public function candidatoPresenca()
    {
        return $this->hasMany('App\Models\CandidatoPresenca', 'cd_candidato_can', 'cd_candidato_can');
    }

    public function candidatoPresencaPrimeiroDia()
    {
        return $this->hasOne('App\Models\CandidatoPresenca', 'cd_candidato_can', 'cd_candidato_can')->where('cd_prova_pro', 1);
    }

    public function candidatoPresencaSegundoDia()
    {
        return $this->hasOne('App\Models\CandidatoPresenca', 'cd_candidato_can', 'cd_candidato_can')->where('cd_prova_pro', 2);
    }

    public function cartaoResposta()
    {
        return $this->hasMany('App\Models\CartaoResposta', 'cd_candidato_can', 'cd_candidato_can');
    }

    public function motivoCancelamentoInscricao(){
        return $this->hasOne('App\Models\MotivoCancelamentoInscricao','cd_motivo_cancelamento_inscricao_moc','cd_motivo_cancelamento_moc');
    }

    public function pontoCandidatoAcertos(){
      return $this->hasOne('App\Models\PontoCandidatoAcertos','cd_candidato_can','cd_candidato_can');
    }

    public function getNome(){
        return ($this->nm_social_can ) ? $this->nm_social_can : $this->nm_candidato_can ;
    }

    public function getEscolaPublica(){
        return ($this->fl_ensino_publico_can) ? '<span class="label label-lg label-light-success label-inline">ESCOLA PÚBLICA</span>' : '<span class="label label-lg label-light-danger label-inline">NÃO ESCOLA PÚBLICA</span>' ;
    }

    public function isento(){
        return $this->hasMany('App\Models\Isento', 'cd_candidato_can', 'cd_candidato_can');
    }

    public function getSexo()
    {
      $sql = "SELECT s.nm_sigla_sex, count(*)
                FROM pessoa.pessoa_pes p,
                    processos_seletivos.candidato_can c,
                    pessoa.sexo_sex s
                WHERE p.cd_pessoa_pes = c.cd_pessoa_pes
                and p.cd_sexo_sex = s.cd_sexo_sex
                AND c.cd_evento_eve = 101
                and c.fl_homologado_can = true
                and c.deleted_at isnull
                group by s.nm_sigla_sex
                ORDER BY nm_sigla_sex";

      return DB::connection('pgsql')->select($sql);
    }

    public function getInscritos()
    {
      $sql = "select
                    t3.sg_instituicao_ies as instituicao,
                    t5.fl_homologado_can,
                    count(*) as total
                from
                    processos_seletivos.opcao_candidato_opc t0
                    inner join processos_seletivos.curso_evento_cue t1 on (t0.cd_curso_evento_cue = t1.cd_curso_evento_cue)
                    inner join processos_seletivos.curso_cur t2 on (t1.cd_curso_cur = t2.cd_curso_cur)
                    inner join processos_seletivos.instituicao_ensino_superior_ies t3 on (t2.cd_instituicao_ies = t3.cd_instituicao_ies)
                    inner join processos_seletivos.campus_cam t4 on (t2.cd_campus_cam = t4.cd_campus_cam)
                    inner join processos_seletivos.candidato_can t5 on (t0.cd_candidato_can = t5.cd_candidato_can)
                where
                    t1.cd_evento_eve  = 101
                and	t0.nu_opcao_opc = '1'
                and t5.deleted_at isnull
                group by
                    t3.sg_instituicao_ies, t5.fl_homologado_can
                order by t3.sg_instituicao_ies, t5.fl_homologado_can ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getRacas()
    {
      $sql = "select t2.nm_raca_rac as raca, count(*) as total
            from pessoa.pessoa_pes t1
            right join pessoa.raca_rac t2 on t1.cd_raca_rac = t2.cd_raca_rac
            join processos_seletivos.candidato_can t3 on t1.cd_pessoa_pes = t3.cd_pessoa_pes and t3.cd_evento_eve = 101 and t3.fl_homologado_can
            group by t2.nm_raca_rac
            order by t2.nm_raca_rac";

      return DB::connection('pgsql')->select($sql);
    }

    public function getInscritosLocal()
    {
      $sql = "SELECT t2.nm_local_prova_lop,
                COUNT(t3.*) as total,
                COUNT(t3.cd_candidato_can) filter (WHERE t3.fl_homologado_can = true) as homologados
                FROM processos_seletivos.local_prova_evento_lpe t1
                JOIN processos_seletivos.local_prova_lop t2 ON t1.cd_local_prova_lop = t2.cd_local_prova_lop
                LEFT JOIN processos_seletivos.candidato_can t3 ON t1.cd_local_prova_evento_lpe = t3.cd_local_prova_evento_lpe
                WHERE t1.cd_evento_eve = 101
                AND t3.deleted_at IS NULL
                GROUP BY t2.nm_local_prova_lop
                ORDER BY t2.nm_local_prova_lop";

      return DB::connection('pgsql')->select($sql);
    }

    public static function validaPagTesouro($data)
    {
        if(is_null($data))
            $data = " now() ";
        else
            $data = "'".$data."'";

      $sql = "update processos_seletivos.candidato_can
                set fl_homologado_can = true ,
                    dt_inscricao_homologada_can = $data,
                    cd_tipo_homologacao_candidato_thc = 1
                where cd_candidato_can in (
                    select t0.cd_candidato_can
                    from processos_seletivos.candidato_can t0
                        inner join processos_seletivos.pagamento_pag t1 on (t0.cd_candidato_can = t1.cd_candidato_can)
                    where t1.situacao = 'CONCLUIDO'
                    and (t0.fl_homologado_can =  false  or t0.fl_homologado_can is null)
                )";

      return DB::connection('pgsql')->select($sql);
    }

    public function buscaCartaoPorProva($evento,$prova, $whereInterior){
        $sql = "SELECT t1.nu_inscricao_can,
                        CASE WHEN t1.nm_social_can IS NULL THEN UPPER(t1.nm_candidato_can) ELSE UPPER(t1.nm_social_can) END AS nm_candidato_can,
                        t3.nm_tipo_tip,
                        t7.cd_local_prova_lop,
                        t5.cd_setor_sel,
                        t5.cd_unico_sel,
                        t8.nu_grupo_gru,
                        t1.cd_ordem_can
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop $whereInterior
                        join processos_seletivos.grupo_gru t8 on t1.cd_grupo_gru = t8.cd_grupo_gru
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t8.nu_grupo_gru,
                        t1.cd_ordem_can";

        return DB::connection('pgsql')->select($sql);
    }

    public function buscaCartaoRedacaoDiscursiva($evento, $whereInterior){
        $sql = "SELECT t1.nu_inscricao_can,
                        t7.cd_local_prova_lop,
                        t5.cd_setor_sel,
                        t5.cd_unico_sel,
                        t8.nu_grupo_gru,
                        t1.cd_ordem_can
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.grupo_gru t8 on t1.cd_grupo_gru = t8.cd_grupo_gru
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop $whereInterior
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t8.nu_grupo_gru,
                        t1.cd_ordem_can";

        return DB::connection('pgsql')->select($sql);
    }

    public function buscaCandidatosLocalSetorProva($evento,$prova, $whereLocal = '', $whereSetor = '', $whereGrupo = '', $order = ' t1.cd_ordem_can'){
        $sql = "SELECT t1.nu_inscricao_can,
                        coalesce(UPPER(t1.nm_social_can), UPPER(t1.nm_candidato_can)) as nm_candidato_can,
                        t3.nm_tipo_tip,
                        t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru as grupo,
                        t10.nu_grupo_gru,
                        t1.cd_ordem_can,
                        t8.nm_documento_doc as cpf,
                        t9.fl_canhoto_pes

                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                        LEFT JOIN pessoa.documento_doc t8 ON t1.cd_pessoa_pes = t8.cd_pessoa_pes AND t8.cd_tipo_tpd = 1
                        join pessoa.pessoa_pes t9 ON t1.cd_pessoa_pes = t9.cd_pessoa_pes
                        join processos_seletivos.grupo_gru t10 on t10.cd_grupo_gru = t1.cd_grupo_gru
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                        $whereGrupo
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t10.nu_grupo_gru,
                        $order
                        ";

        return DB::connection('pgsql')->select($sql);
    }

    public function buscaCandidatosLocalSetor($evento, $whereLocal = '', $whereSetor = '', $whereGrupo = ''){
        $sql = "SELECT
  t1.nu_inscricao_can,
  coalesce(UPPER(t1.nm_social_can), UPPER(t1.nm_candidato_can)) as nm_candidato_can,
  t3.nm_tipo_tip AS prova1,
  t30.nm_tipo_tip AS prova2,
  processos_seletivos.lingua_lin.nm_lingua_lin,
  t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
  t5.cd_setor_sel as setor,
  t5.nm_setor_sel,
  t5.cd_unico_sel,
  t1.cd_grupo_gru AS grupo,
  t10.nu_grupo_gru,
  t1.cd_ordem_can,
  t8.nm_documento_doc as cpf,
  t9.fl_canhoto_pes
FROM
  (
    (
      (
        (
          (
            (
              (
                processos_seletivos.tipo_prova_tip AS t3
                INNER JOIN processos_seletivos.candidato_tipo_prova_ctp AS t2 ON t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip
              )
              INNER JOIN processos_seletivos.prova_pro AS pp ON t3.cd_prova_pro = pp.cd_prova_pro
            )
            INNER JOIN (
              (
                processos_seletivos.setor_sel AS t5
                INNER JOIN processos_seletivos.setor_evento_see AS t4 ON t5.cd_setor_sel = t4.cd_setor_sel
              )
              INNER JOIN (
                processos_seletivos.candidato_can AS t1
                INNER JOIN processos_seletivos.grupo_gru AS t10 ON t1.cd_grupo_gru = t10.cd_grupo_gru
              ) ON t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
            ) ON t2.cd_candidato_can = t1.cd_candidato_can
          )
          INNER JOIN processos_seletivos.candidato_tipo_prova_ctp AS t20 ON t1.cd_candidato_can = t20.cd_candidato_can
        )
        INNER JOIN processos_seletivos.tipo_prova_tip AS t30 ON t20.cd_tipo_prova_tip = t30.cd_tipo_prova_tip
      )
      INNER JOIN processos_seletivos.prova_pro AS pp0 ON t30.cd_prova_pro = pp0.cd_prova_pro
    )
    INNER JOIN processos_seletivos.lingua_evento_lie AS lie ON t1.cd_lingua_evento_lie = lie.cd_lingua_evento_lie
  )
  INNER JOIN processos_seletivos.lingua_lin ON lie.cd_lingua_lin = processos_seletivos.lingua_lin.cd_lingua_lin
  LEFT JOIN pessoa.documento_doc as t8 ON t1.cd_pessoa_pes = t8.cd_pessoa_pes AND t8.cd_tipo_tpd = 1
                        join pessoa.pessoa_pes as t9 ON t1.cd_pessoa_pes = t9.cd_pessoa_pes
                        join processos_seletivos.local_prova_evento_lpe as t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t6.cd_local_prova_evento_lpe = t4.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop as t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
WHERE
  (
    (
      (t1.cd_evento_eve)= $evento
    )
    AND (
      (t1.fl_homologado_can)= true
    )
    AND (
      (pp.nu_prova_pro)= 1
    )
    AND (
      (pp0.nu_prova_pro)= 2
    )
  )
    $whereLocal
    $whereGrupo
ORDER BY t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t1.nm_candidato_can

                        ";

/*
SELECT t1.nu_inscricao_can,
                        coalesce(UPPER(t1.nm_social_can), UPPER(t1.nm_candidato_can)) as nm_candidato_can,
                        t3.nm_tipo_tip as prova1,
                        t30.nm_tipo_tip as prova2,
                        lin.nm_lingua_lin,
                        t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru as grupo,
                        t10.nu_grupo_gru,
                        t1.cd_ordem_can,
                        t8.nm_documento_doc as cpf,
                        t9.fl_canhoto_pes

                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve
                        join processos_seletivos.prova_pro pp on pp.cd_evento_eve = t3.cd_evento_eve and pp.cd_prova_pro = t3.cd_prova_pro and pp.nu_prova_pro = 1
                        join processos_seletivos.lingua_evento_lie lie on lie.cd_evento_eve = t3.cd_evento_eve and lie.cd_lingua_evento_lie = t3.cd_lingua_evento_lie
                        join processos_seletivos.lingua_lin lin on lin.cd_lingua_lin =  lie.cd_lingua_lin
                        join processos_seletivos.tipo_prova_tip t30 on t30.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t30.cd_evento_eve = t1.cd_evento_eve
                        join processos_seletivos.prova_pro pp2 on pp2.cd_evento_eve = t3.cd_evento_eve and pp2.cd_prova_pro = t3.cd_prova_pro and pp2.nu_prova_pro = 2
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                        LEFT JOIN pessoa.documento_doc t8 ON t1.cd_pessoa_pes = t8.cd_pessoa_pes AND t8.cd_tipo_tpd = 1
                        join pessoa.pessoa_pes t9 ON t1.cd_pessoa_pes = t9.cd_pessoa_pes
                        join processos_seletivos.grupo_gru t10 on t10.cd_grupo_gru = t1.cd_grupo_gru
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                        $whereGrupo
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t1.nm_candidato_can
*/


        return DB::connection('pgsql')->select($sql);
    }

    public function buscaGruposParaAta($evento,$prova, $whereLocal = '', $whereSetor = '', $whereGrupo = ''){
        $sql = "SELECT count(*) as total,
                        t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru as grupo,
                        t10.nu_grupo_gru
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                        join processos_seletivos.grupo_gru t10 on t10.cd_grupo_gru = t1.cd_grupo_gru
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                        $whereGrupo
                    GROUP BY
                        t7.cd_local_prova_lop, t7.nm_local_prova_lop,
                        t5.cd_setor_sel, t5.nm_setor_sel,
                        t1.cd_grupo_gru,t10.nu_grupo_gru
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t10.nu_grupo_gru
                        ";

        return DB::connection('pgsql')->select($sql);
    }

    public function buscaSetoresParaAta($evento,$prova, $whereLocal = '', $whereSetor = ''){
        $sql = "SELECT count(*) as total,
                        t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel
                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve and t3.cd_prova_pro = $prova
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                    GROUP BY
                        t7.cd_local_prova_lop, t7.nm_local_prova_lop,
                        t5.cd_setor_sel, t5.nm_setor_sel, t5.cd_unico_sel
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel
                        ";

        return DB::connection('pgsql')->select($sql);
    }

    public function getHomonimos($evento, $whereLocal, $whereSetor, $whereGrupo)
    {
        $sql = "SELECT t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru as grupo,
                        t10.nu_grupo_gru,
                        t1.cd_ordem_can,
                        t1.nm_candidato_can,
                        t1.nu_inscricao_can,
                        t8.nm_documento_doc as cpf
                    FROM  (
                    SELECT  t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru as grupo,
                        t10.nu_grupo_gru,
                        t1.nm_candidato_can

                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                        LEFT JOIN pessoa.documento_doc t8 ON t1.cd_pessoa_pes = t8.cd_pessoa_pes AND t8.cd_tipo_tpd = 1
                        join pessoa.pessoa_pes t9 ON t1.cd_pessoa_pes = t9.cd_pessoa_pes
                        join processos_seletivos.grupo_gru t10 on t10.cd_grupo_gru = t1.cd_grupo_gru
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                        $whereGrupo
                    GROUP BY
                        t7.cd_local_prova_lop, t7.nm_local_prova_lop,
                        t5.cd_setor_sel, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru, t10.nu_grupo_gru,
                        t1.nm_candidato_can
                    having count(*) >= 2
                    ) t join processos_seletivos.candidato_can t1 on t1.nm_candidato_can = t.nm_candidato_can
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                        LEFT JOIN pessoa.documento_doc t8 ON t1.cd_pessoa_pes = t8.cd_pessoa_pes AND t8.cd_tipo_tpd = 1
                        join pessoa.pessoa_pes t9 ON t1.cd_pessoa_pes = t9.cd_pessoa_pes
                        join processos_seletivos.grupo_gru t10 on t10.cd_grupo_gru = t1.cd_grupo_gru
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                        $whereGrupo";

        return DB::connection('pgsql')->select($sql);

    }

    public function getProvasAmpliadasPorGrupo($evento, $whereLocal = '', $whereSetor = '', $whereGrupo = ''){
        $sql = "SELECT
  t1.nu_inscricao_can,
  coalesce(UPPER(t1.nm_social_can), UPPER(t1.nm_candidato_can)) as nm_candidato_can,
  t3.nm_tipo_tip AS prova1,
  t30.nm_tipo_tip AS prova2,
  processos_seletivos.lingua_lin.nm_lingua_lin,
  t7.cd_local_prova_lop,
  t5.cd_setor_sel as setor,
  t5.nm_setor_sel,
  t5.cd_unico_sel,
  t1.cd_grupo_gru AS grupo,
  t10.nu_grupo_gru,
  t1.cd_ordem_can
FROM
  (
    (
      (
        (
          (
            (
              (
                processos_seletivos.tipo_prova_tip AS t3
                INNER JOIN processos_seletivos.candidato_tipo_prova_ctp AS t2 ON t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip
              )
              INNER JOIN processos_seletivos.prova_pro AS pp ON t3.cd_prova_pro = pp.cd_prova_pro
            )
            INNER JOIN (
              (
                processos_seletivos.setor_sel AS t5
                INNER JOIN processos_seletivos.setor_evento_see AS t4 ON t5.cd_setor_sel = t4.cd_setor_sel $whereSetor
              )
              INNER JOIN (
                processos_seletivos.candidato_can AS t1
                INNER JOIN processos_seletivos.grupo_gru AS t10 ON t1.cd_grupo_gru = t10.cd_grupo_gru
              ) ON t4.cd_setor_evento_see = t1.cd_setor_evento_see
            ) ON t2.cd_candidato_can = t1.cd_candidato_can
          )
          INNER JOIN processos_seletivos.candidato_tipo_prova_ctp AS t20 ON t1.cd_candidato_can = t20.cd_candidato_can
        )
        INNER JOIN processos_seletivos.tipo_prova_tip AS t30 ON t20.cd_tipo_prova_tip = t30.cd_tipo_prova_tip
      )
      INNER JOIN processos_seletivos.prova_pro AS pp0 ON t30.cd_prova_pro = pp0.cd_prova_pro
    )
    INNER JOIN processos_seletivos.lingua_evento_lie AS lie ON t1.cd_lingua_evento_lie = lie.cd_lingua_evento_lie
  )
  INNER JOIN processos_seletivos.lingua_lin ON lie.cd_lingua_lin = processos_seletivos.lingua_lin.cd_lingua_lin
                        join processos_seletivos.local_prova_evento_lpe as t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t6.cd_local_prova_evento_lpe = t4.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop as t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                  join processos_seletivos.candidato_condicao_especial_cce t11 on t11.cd_candidato_can = t1.cd_candidato_can and t11.cd_evento_eve = t1.cd_evento_eve
                            and t11.cd_situacao_condicao_especial_sce in (2,4) /* 2 = deferido, 4 = parcialmente deferido */
                            and t11.cd_condicao_especial_evento_cee in (select cd_condicao_especial_evento_cee from processos_seletivos.condicao_especial_evento_cee where cd_evento_eve = $evento and cd_condicao_especial_coe in (1, 99)) and (t11.nm_outra_cce is null or t11.nm_outra_cce ilike '%ampliad%' or t11.nm_outra_cce ilike '%fonte%')
WHERE
  (
    (
      (t1.cd_evento_eve)= $evento
    )
    AND (
      (t1.fl_homologado_can)= true
    )
    AND (
      (pp.nu_prova_pro)= 1
    )
    AND (
      (pp0.nu_prova_pro)= 2
    )
  )
  $whereLocal
  $whereGrupo
ORDER BY t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t10.nu_grupo_gru,
                        t1.nm_candidato_can

";



/*
        "SELECT t1.nu_inscricao_can,
                        coalesce(UPPER(t1.nm_social_can), UPPER(t1.nm_candidato_can)) as nm_candidato_can,
                        t3.nm_tipo_tip as prova1,
                        t30.nm_tipo_tip as prova2,
                        t7.cd_local_prova_lop as local, t7.nm_local_prova_lop,
                        t5.cd_setor_sel as setor, t5.nm_setor_sel, t5.cd_unico_sel,
                        t1.cd_grupo_gru as grupo,
                        t8.nu_grupo_gru,
                        t1.cd_ordem_can

                    FROM  processos_seletivos.candidato_can t1
                        join processos_seletivos.candidato_tipo_prova_ctp t2 on t2.cd_candidato_can = t1.cd_candidato_can
                        join processos_seletivos.tipo_prova_tip t3 on t3.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t3.cd_evento_eve = t1.cd_evento_eve
                        join processos_seletivos.prova_pro pp on pp.cd_evento_eve = t3.cd_evento_eve and pp.cd_prova_pro = t3.cd_prova_pro and pp.nu_prova_pro = 1
                        join processos_seletivos.tipo_prova_tip t30 on t30.cd_tipo_prova_tip = t2.cd_tipo_prova_tip and t30.cd_evento_eve = t1.cd_evento_eve
                        join processos_seletivos.prova_pro pp2 on pp2.cd_evento_eve = t3.cd_evento_eve and pp2.cd_prova_pro = t3.cd_prova_pro and pp2.nu_prova_pro = 2
                        join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe and t4.cd_setor_evento_see = t1.cd_setor_evento_see $whereSetor
                        join processos_seletivos.setor_sel t5 on t5.cd_setor_sel = t4.cd_setor_sel
                        join processos_seletivos.local_prova_evento_lpe t6 on t6.cd_evento_eve = t1.cd_evento_eve and t6.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe
                        join processos_seletivos.local_prova_lop t7 on t7.cd_local_prova_lop = t6.cd_local_prova_lop
                        join processos_seletivos.grupo_gru t8 on t8.cd_grupo_gru = t1.cd_grupo_gru
                        join processos_seletivos.candidato_condicao_especial_cce t9 on t9.cd_candidato_can = t1.cd_candidato_can and t9.cd_evento_eve = t1.cd_evento_eve
                            and t9.cd_situacao_condicao_especial_sce in (2,4)
                            and t9.cd_condicao_especial_evento_cee in (select cd_condicao_especial_evento_cee from processos_seletivos.condicao_especial_evento_cee where cd_evento_eve = $evento and cd_condicao_especial_coe in (1, 99)) and (t9.nm_outra_cce is null or t9.nm_outra_cce ilike '%ampliad%' or t9.nm_outra_cce ilike '%fonte%')
                    WHERE
                        t1.cd_evento_eve = $evento
                        and t1.fl_homologado_can = true
                        $whereLocal
                        $whereGrupo
                    ORDER BY
                        t7.cd_local_prova_lop,
                        t5.cd_unico_sel,
                        t8.nu_grupo_gru,
                        nm_candidato_can
                        ";*/

        return DB::connection('pgsql')->select($sql);
    }

    public function getInscritosCanhotos($evento, $whereLocal = '', $whereSetor = '', $whereGrupo = '')
    {
      $sql = "SELECT t2.nm_local_prova_lop, t2.cd_local_prova_lop,
                    t4.cd_setor_sel, t7.nm_setor_sel,
                    t6.cd_grupo_gru, t6.nu_grupo_gru, t6.nm_grupo_gru,
                COUNT(t3.cd_candidato_can) as totalCandidatos,
                COUNT(t5.cd_pessoa_pes) filter (WHERE t5.fl_canhoto_pes = 'S') as totalCanhotos
                FROM processos_seletivos.local_prova_evento_lpe t1
                join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe $whereSetor
                JOIN processos_seletivos.local_prova_lop t2 ON t1.cd_local_prova_lop = t2.cd_local_prova_lop
                LEFT JOIN processos_seletivos.candidato_can t3 ON t1.cd_local_prova_evento_lpe = t3.cd_local_prova_evento_lpe and t3.cd_setor_evento_see = t4.cd_setor_evento_see
                join pessoa.pessoa_pes t5 on t5.cd_pessoa_pes = t3.cd_pessoa_pes
                join processos_seletivos.grupo_gru t6 on t6.cd_grupo_gru = t3.cd_grupo_gru and t3.cd_grupo_gru = t6.cd_grupo_gru
                join processos_seletivos.setor_sel t7 on t7.cd_setor_sel = t4.cd_setor_sel
                WHERE t1.cd_evento_eve = $evento
                $whereLocal
                AND t3.deleted_at IS NULL
                and t3.fl_homologado_can = true
                GROUP BY t2.nm_local_prova_lop, t2.cd_local_prova_lop,
                    t4.cd_setor_sel, t7.nm_setor_sel,
                    t6.cd_grupo_gru, t6.nu_grupo_gru, t6.nm_grupo_gru
                having COUNT(t5.cd_pessoa_pes) filter (WHERE t5.fl_canhoto_pes = 'S') > 0
                ORDER BY t2.cd_local_prova_lop,
                    t4.cd_setor_sel, t7.nm_setor_sel,
                    t6.nu_grupo_gru,t6.nm_grupo_gru";

      return DB::connection('pgsql')->select($sql);
    }

    public function getTotalCandidatosGrupos($evento, $whereLocal = '', $whereSetor = '', $whereGrupo = '')
    {
      $sql = "SELECT t2.nm_local_prova_lop, t2.cd_local_prova_lop,
                    t4.cd_setor_sel, t7.nm_setor_sel,
                    t6.cd_grupo_gru, t6.nu_grupo_gru, t6.nm_grupo_gru, t6.ds_localizacao_gru,
                COUNT(t3.cd_candidato_can) as totalCandidatos
                FROM processos_seletivos.local_prova_evento_lpe t1
                join processos_seletivos.setor_evento_see t4 on t4.cd_evento_eve = t1.cd_evento_eve and t4.cd_local_prova_evento_lpe = t1.cd_local_prova_evento_lpe $whereSetor
                JOIN processos_seletivos.local_prova_lop t2 ON t1.cd_local_prova_lop = t2.cd_local_prova_lop
                LEFT JOIN processos_seletivos.candidato_can t3 ON t1.cd_local_prova_evento_lpe = t3.cd_local_prova_evento_lpe and t3.cd_setor_evento_see = t4.cd_setor_evento_see
                join processos_seletivos.grupo_gru t6 on t6.cd_grupo_gru = t3.cd_grupo_gru and t3.cd_grupo_gru = t6.cd_grupo_gru
                join processos_seletivos.setor_sel t7 on t7.cd_setor_sel = t4.cd_setor_sel
                WHERE t1.cd_evento_eve = $evento
                $whereLocal
                AND t3.deleted_at IS NULL
                and t3.fl_homologado_can = true
                GROUP BY t2.nm_local_prova_lop, t2.cd_local_prova_lop,
                    t4.cd_setor_sel, t7.nm_setor_sel,
                    t6.cd_grupo_gru, t6.nu_grupo_gru, t6.nm_grupo_gru, t6.ds_localizacao_gru
                ORDER BY t2.cd_local_prova_lop,
                    t4.cd_setor_sel, t7.nm_setor_sel,
                    t6.nu_grupo_gru, t6.nm_grupo_gru, t6.ds_localizacao_gru";

      return DB::connection('pgsql')->select($sql);
    }
}
