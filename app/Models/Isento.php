<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Isento extends Model
{

  use SoftDeletes;
  
	protected $connection = 'pgsql';
  protected $table = 'processos_seletivos.isentos_ise';
	protected $primaryKey = 'cd_isentos_ise';
    protected $fillable = ['cd_evento_eve',
                           'fl_deferimento_ise',
                           'created_at',
                           'nu_nis_ise',
                           'cd_isencao_indeferimento_isi',
                           'cd_razao_isencao_rai',
                           'cd_candidato_can'
    					  ]; //whitelist de inserção

    public $timestamps = true;

    public function razaoIsencao(){
      return $this->hasOne('App\Models\RazaoIsencao', 'cd_razao_isencao_rai', 'cd_razao_isencao_rai');
    }

    public function candidato(){
      return $this->hasOne('App\Models\Candidato', 'cd_candidato_can', 'cd_candidato_can');
    }

    public function indeferimento(){
        return $this->hasOne('App\Models\IsencaoIndeferimento', 'cd_isencao_indeferimento_isi', 'cd_isencao_indeferimento_isi');
    }

    public function getIsentosPendentesAvaliacao($usuario)
    {
      //Retorna o id de isento que ainda não possui as duas avaliações válidas
      $sql = "select min(cd_isentos_ise) as isento 
              from processos_seletivos.isentos_ise 
              where cd_razao_isencao_rai = 1
              and cd_isentos_ise not in (select cd_isentos_ise
                          from processos_seletivos.avaliacao_isencao_avi 
                          where cd_usuario_usu = $usuario
                          group by cd_isentos_ise 
                          having count(*) = 1)
              and cd_isentos_ise not in (select cd_isentos_ise
                          from processos_seletivos.avaliacao_isencao_avi 
                          group by cd_isentos_ise 
                          having count(*) = 2)
              and cd_candidato_can not in (SELECT cd_candidato_can FROM processos_seletivos.candidato_can WHERE deleted_at IS NOT NULL)";

      return DB::connection('pgsql')->select($sql)[0]->isento;
    }

    public function getDadosArquivoNis($evento){

		  return DB::connection('pgsql')->select("SELECT unaccent(t1.nm_candidato_can) as nm_pessoa_pes, t2.nu_nis_ise, t5.nm_documento_doc as rg, t6.nm_sigla_ore, to_char(t5.dt_expedicao_doc,'DDMMYYYY')as dt_expedicao_doc, to_char(t3.dt_nascimento_pes,'DDMMYYYY') as dt_nascimento_pes, t4.nm_sexo_sex, t7.nm_documento_doc as cpf, unaccent(t3.nm_mae_pes) as nm_mae_pes
        FROM processos_seletivos.candidato_can t1
        join processos_seletivos.isentos_ise t2 on t1.cd_evento_eve = t2.cd_evento_eve and t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_razao_isencao_rai = 2
        join pessoa.pessoa_pes t3 on t1.cd_pessoa_pes = t3.cd_pessoa_pes 
        JOIN pessoa.sexo_sex t4 ON t3.cd_sexo_sex = t4.cd_sexo_sex
        LEFT JOIN pessoa.documento_doc t5 ON t3.cd_pessoa_pes = t5.cd_pessoa_pes AND t5.cd_tipo_tpd = 2
        LEFT JOIN pessoa.orgao_expeditor_ore t6 ON t5.cd_orgao_expeditor_ore = t6.cd_orgao_expeditor_ore
        LEFT JOIN pessoa.documento_doc t7 ON t3.cd_pessoa_pes = t7.cd_pessoa_pes AND t7.cd_tipo_tpd = 1
        WHERE t1.cd_evento_eve = $evento
        ORDER BY t1.nm_candidato_can
      ");
	
    }

    public function getDadosArquivoNisCandidatos($candidatos, $evento){

      return DB::connection('pgsql')->select("SELECT unaccent(t3.nm_pessoa_pes) as nm_pessoa_pes, t2.nu_nis_ise, t5.nm_documento_doc as rg, t6.nm_sigla_ore, to_char(t5.dt_expedicao_doc,'DDMMYYYY')as dt_expedicao_doc, to_char(t3.dt_nascimento_pes,'DDMMYYYY') as dt_nascimento_pes, t4.nm_sexo_sex, t7.nm_documento_doc as cpf, unaccent(t3.nm_mae_pes) as nm_mae_pes
        FROM processos_seletivos.candidato_can t1
        join processos_seletivos.isentos_ise t2 on t1.cd_evento_eve = t2.cd_evento_eve and t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_razao_isencao_rai = 2
        join pessoa.pessoa_pes t3 on t1.cd_pessoa_pes = t3.cd_pessoa_pes 
        JOIN pessoa.sexo_sex t4 ON t3.cd_sexo_sex = t4.cd_sexo_sex
        LEFT JOIN pessoa.documento_doc t5 ON t3.cd_pessoa_pes = t5.cd_pessoa_pes AND t5.cd_tipo_tpd = 2
        LEFT JOIN pessoa.orgao_expeditor_ore t6 ON t5.cd_orgao_expeditor_ore = t6.cd_orgao_expeditor_ore
        LEFT JOIN pessoa.documento_doc t7 ON t3.cd_pessoa_pes = t7.cd_pessoa_pes AND t7.cd_tipo_tpd = 1
        WHERE t1.cd_evento_eve = $evento
        AND t2.cd_isentos_ise in ($candidatos)
        ORDER BY t3.nm_pessoa_pes
      ");
  
    }

public function verificaNIS($nis, $cpf, $evento){

    $resultado = DB::connection('pgsql')->select("SELECT t1.cd_candidato_can
        FROM processos_seletivos.candidato_can t1
        join processos_seletivos.isentos_ise t2 on t1.cd_evento_eve = t2.cd_evento_eve and t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_razao_isencao_rai = 2 and t2.nu_nis_ise = $nis
        join pessoa.pessoa_pes t3 on t1.cd_pessoa_pes = t3.cd_pessoa_pes 
        JOIN pessoa.documento_doc t7 ON t3.cd_pessoa_pes = t7.cd_pessoa_pes AND t7.cd_tipo_tpd = 1 and t7.nm_documento_doc = '".$cpf."'
        WHERE t1.cd_evento_eve = $evento");

    if(isset($resultado[0]))
      return $resultado[0]->cd_candidato_can;
    else 
      return false;
}

public function verificaIsencaoLei($cpf, $evento){
    $resultado = DB::connection('pgsql')->select("SELECT t1.cd_candidato_can
        FROM processos_seletivos.candidato_can t1
        join processos_seletivos.isentos_ise t2 on t1.cd_evento_eve = t2.cd_evento_eve and t1.cd_candidato_can = t2.cd_candidato_can and t2.cd_razao_isencao_rai = 1 and fl_deferimento_ise = true
        join pessoa.pessoa_pes t3 on t1.cd_pessoa_pes = t3.cd_pessoa_pes 
        JOIN pessoa.documento_doc t7 ON t3.cd_pessoa_pes = t7.cd_pessoa_pes AND t7.cd_tipo_tpd = 1 and t7.nm_documento_doc = '".$cpf."'
        WHERE t1.cd_evento_eve = $evento");

    if(isset($resultado[0]))
      return $resultado[0]->cd_candidato_can;
    else 
      return false;
}

/*public function indefereIsencaoLei($cand, $indeferimento){
    return DB::connection('pgsql')->update("UPDATE concurso.isento_ise SET fl_isencao_deferida_ise = 'N', cd_motivo_indeferimento_isencao_mii = ".$indeferimento." WHERE  cd_candidato_can = $cand and cd_motivo_isencao_moi = 1 ");
    //dd($sel);".$cand."
  
}*/

public function defereIsencaoNIS($cand){
    return DB::connection('pgsql')->update("UPDATE concurso.isento_ise SET fl_isencao_deferida_ise = 'S' WHERE cd_candidato_can = $cand and cd_motivo_isencao_moi = 2 ");
    //dd($sel);".$cand."
  
}

public static function totalIsencoesDuplas($evento){
  
     $resultado = DB::connection('pgsql')->select("SELECT count(*) AS total FROM concurso.isento_ise t1, concurso.inscricao_vw t3 WHERE t3.cd_evento_eve = $evento and t1.cd_candidato_can = t3.cd_candidato_can and t1.cd_motivo_isencao_moi = 1 AND t1.cd_candidato_can IN (SELECT t2.cd_candidato_can FROM concurso.inscricao_vw t4, concurso.isento_ise t2 WHERE t4.cd_evento_eve = $evento and t2.cd_candidato_can = t4.cd_candidato_can and t2.cd_motivo_isencao_moi = 2)");

    if(isset($resultado[0]))
      return $resultado[0]->total;
    else 
      return 0;
  
  }


}