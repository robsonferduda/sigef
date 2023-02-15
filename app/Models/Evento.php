<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Evento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.evento_eve';
    protected $primaryKey = 'cd_evento_eve';

    protected $fillable = ['nm_evento_eve'];

    public function categoria(){
        return $this->belongsToMany('App\Models\Categoria', 'processos_seletivos.categoria_evento_cae', 'cd_evento_eve','cd_categoria_cat');
    }

    public function condicoes(){
        return $this->belongsToMany(CondicaoEspecial::class, 'processos_seletivos.condicao_especial_evento_cee','cd_evento_eve','cd_condicao_especial_coe')->withPivot('fl_junta_medica_cee','fl_laudo_cee')->withTimestamps();
    }

    public function eventoParametros(){
        return $this->hasOne('App\Models\EventoParametros', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function informacaoBoleto(){
        return $this->hasOne('App\Models\InformacaoBoleto', 'cd_informacao_ibo', 'cd_informacao_ibo');
    }

    public function getSabatistasLibras()
    {
      $sql = "SELECT t3.cd_local_prova_lop, t3.nm_local_prova_lop, t1.nu_inscricao_can, t1.nm_candidato_can, fl_prova_libras_can, cd_lingua_evento_lie
                FROM processos_seletivos.candidato_can t1
                JOIN processos_seletivos.local_prova_evento_lpe t2 ON t1.cd_local_prova_evento_lpe = t2.cd_local_prova_evento_lpe
                JOIN processos_seletivos.local_prova_lop t3 ON t2.cd_local_prova_lop = t3.cd_local_prova_lop
                WHERE t2.cd_evento_eve = 101
                AND t1.fl_homologado_can = true
                AND t1.fl_sabatista_can = true
                AND t1.fl_apenado_can = false
                AND (t1.fl_prova_libras_can = true OR cd_lingua_evento_lie = 6)
                ORDER BY nm_candidato_can ";

      return DB::connection('pgsql')->select($sql);
    }

    public function getSabatistasLocal()
    {
      $sql = "SELECT t3.cd_local_prova_lop,
                    t3.nm_local_prova_lop,
                    COUNT(*) as total,
	                COUNT(t1.cd_candidato_can) filter (where t1.cd_setor_evento_see IS NOT NULL) as alocados
                FROM processos_seletivos.candidato_can t1
                JOIN processos_seletivos.local_prova_evento_lpe t2 ON t1.cd_local_prova_evento_lpe = t2.cd_local_prova_evento_lpe
                JOIN processos_seletivos.local_prova_lop t3 ON t2.cd_local_prova_lop = t3.cd_local_prova_lop
                WHERE t2.cd_evento_eve = $this->cd_evento_eve
                AND t1.fl_homologado_can = true
                AND t1.fl_sabatista_can = true
                GROUP BY t3.cd_local_prova_lop, t3.nm_local_prova_lop
                ORDER BY t3.nm_local_prova_lop";

      return DB::connection('pgsql')->select($sql);
    }

    public function getLibrasLocal()
    {
      $sql = "SELECT t3.cd_local_prova_lop,
                t3.nm_local_prova_lop,
                COUNT(*) AS total,
                COUNT(t1.cd_candidato_can) filter (where t1.fl_prova_libras_can is true) as primeira_lingua,
                COUNT(t1.cd_candidato_can) filter (where t1.cd_lingua_evento_lie = 6) as segunda_lingua,
                COUNT(t1.cd_candidato_can) filter (where t1.cd_setor_evento_see IS NOT NULL) as alocados
            FROM processos_seletivos.candidato_can t1
            JOIN processos_seletivos.local_prova_evento_lpe t2 ON t1.cd_local_prova_evento_lpe = t2.cd_local_prova_evento_lpe
            JOIN processos_seletivos.local_prova_lop t3 ON t2.cd_local_prova_lop = t3.cd_local_prova_lop
            WHERE t2.cd_evento_eve = 101
            AND t1.fl_homologado_can = true
            AND t1.fl_sabatista_can = false
            AND t1.fl_apenado_can = false
            AND (t1.fl_prova_libras_can = true OR cd_lingua_evento_lie = 6)
            GROUP BY t3.cd_local_prova_lop, t3.nm_local_prova_lop";

      return DB::connection('pgsql')->select($sql);
    }

    public function getGeralLocal()
    {
        $sql = "SELECT t3.cd_local_prova_lop,
                t2.cd_local_prova_evento_lpe, 
                t3.nm_local_prova_lop,
                COUNT(*) AS total,
                COUNT(t1.cd_candidato_can) filter (where t1.cd_setor_evento_see IS NOT NULL) as alocados
            FROM processos_seletivos.candidato_can t1
            JOIN processos_seletivos.local_prova_evento_lpe t2 ON t1.cd_local_prova_evento_lpe = t2.cd_local_prova_evento_lpe
            JOIN processos_seletivos.local_prova_lop t3 ON t2.cd_local_prova_lop = t3.cd_local_prova_lop
            WHERE t2.cd_evento_eve = 101
            AND t1.fl_homologado_can = true
            GROUP BY t3.cd_local_prova_lop, t2.cd_local_prova_evento_lpe, t3.nm_local_prova_lop
            ORDER BY t3.cd_local_prova_lop";

        return DB::connection('pgsql')->select($sql);
    }

    public function getCanhotosLocal()
    {
        $sql = "SELECT t3.cd_local_prova_lop,
                    t3.nm_local_prova_lop,
                    COUNT(*) AS total,
                    COUNT(t1.cd_candidato_can) filter (where t1.cd_setor_evento_see IS NOT NULL) as alocados
                FROM processos_seletivos.candidato_can t1
                JOIN processos_seletivos.local_prova_evento_lpe t2 ON t1.cd_local_prova_evento_lpe = t2.cd_local_prova_evento_lpe
                JOIN processos_seletivos.local_prova_lop t3 ON t2.cd_local_prova_lop = t3.cd_local_prova_lop
                join pessoa.pessoa_pes t4 on (t1.cd_pessoa_pes = t4.cd_pessoa_pes)
                join processos_seletivos.endereco_end t5 on (t1.cd_candidato_can = t5.cd_candidato_can)
                join processos_seletivos.lingua_evento_lie t6 on (t1.cd_lingua_evento_lie = t6.cd_lingua_evento_lie)
                WHERE t2.cd_evento_eve = 101
                AND t1.fl_homologado_can = true
                and t1.cd_local_prova_evento_lpe = 7
                and t4.fl_canhoto_pes = 'S'
                and	t5.nu_cep_end not between 88000000 AND 88099999
                and	t1.fl_sabatista_can = false and t1.fl_prova_libras_can  = false and t1.fl_apenado_can  = false and t6.cd_lingua_lin <> 6
                GROUP BY t3.cd_local_prova_lop, t3.nm_local_prova_lop";

        return DB::connection('pgsql')->select($sql);
    }

    public function getSabatistasCondicaoEspecial()
    {
      $sql = "SELECT t5.cd_local_prova_lop,
                    t5.nm_local_prova_lop,
                    t2.nu_inscricao_can,
                    t2.nm_candidato_can,
                    t6.nm_condicao_especial_coe,
                    t1.nm_outra_cce,
                    t7.nm_situacao_sce,
                    t7.ds_color_sce
                FROM processos_seletivos.candidato_condicao_especial_cce t1
                JOIN processos_seletivos.candidato_can t2 ON t1.cd_candidato_can = t2.cd_candidato_can
                JOIN processos_seletivos.condicao_especial_evento_cee t3 ON t1.cd_condicao_especial_evento_cee = t3.cd_condicao_especial_evento_cee
                JOIN processos_seletivos.local_prova_evento_lpe t4 ON t2.cd_local_prova_evento_lpe = t4.cd_local_prova_evento_lpe
                JOIN processos_seletivos.local_prova_lop t5 ON t4.cd_local_prova_lop = t5.cd_local_prova_lop
                JOIN processos_seletivos.condicao_especial_coe t6 ON t3.cd_condicao_especial_coe = t6.cd_condicao_especial_coe
                JOIN processos_seletivos.situacao_condicao_especial_sce t7 ON t1.cd_situacao_condicao_especial_sce = t7.cd_situacao_condicao_especial_sce
                WHERE t2.cd_evento_eve = $this->cd_evento_eve
                AND t2.fl_homologado_can = true
                AND t2.fl_sabatista_can = true
                ORDER BY t5.nm_local_prova_lop, t2.nm_candidato_can";

      return DB::connection('pgsql')->select($sql);
    }

    public function getLibrasCondicaoEspecial()
    {
      $sql = "SELECT t5.cd_local_prova_lop, 
                    t5.nm_local_prova_lop,
                    t2.nu_inscricao_can,
                    t2.nm_candidato_can,
                    t6.nm_condicao_especial_coe,
                    t1.nm_outra_cce,
                    t7.nm_situacao_sce,
                    t7.ds_color_sce  
                FROM processos_seletivos.candidato_condicao_especial_cce t1
                JOIN processos_seletivos.candidato_can t2 ON t1.cd_candidato_can = t2.cd_candidato_can 
                JOIN processos_seletivos.condicao_especial_evento_cee t3 ON t1.cd_condicao_especial_evento_cee = t3.cd_condicao_especial_evento_cee 
                JOIN processos_seletivos.local_prova_evento_lpe t4 ON t2.cd_local_prova_evento_lpe = t4.cd_local_prova_evento_lpe 
                JOIN processos_seletivos.local_prova_lop t5 ON t4.cd_local_prova_lop = t5.cd_local_prova_lop 
                JOIN processos_seletivos.condicao_especial_coe t6 ON t3.cd_condicao_especial_coe = t6.cd_condicao_especial_coe 
                JOIN processos_seletivos.situacao_condicao_especial_sce t7 ON t1.cd_situacao_condicao_especial_sce = t7.cd_situacao_condicao_especial_sce 
                WHERE t2.cd_evento_eve = $this->cd_evento_eve
                AND t2.fl_homologado_can = true
                AND (t2.fl_prova_libras_can = true OR cd_lingua_evento_lie = 6)
                ORDER BY t5.nm_local_prova_lop, t2.nm_candidato_can";

      return DB::connection('pgsql')->select($sql);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($controle) {

	    });
    }
}
