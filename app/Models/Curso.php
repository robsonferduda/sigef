<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Curso extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_cur';
    protected $primaryKey = 'cd_curso_cur';

    protected $fillable = ['nm_curso_cur'];

    public function evento(){
        return $this->belongsTo('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function cursoEvento(){
        return $this->belongsTo('App\Models\CursoEvento', 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

    public function campus(){
        return $this->hasOne('App\Models\Campus', 'cd_campus_cam', 'cd_campus_cam');
    }

    public function instituicao(){
        return $this->hasOne('App\Models\Instituicao', 'cd_instituicao_ies', 'cd_instituicao_ies');
    }

    public function getTotaisCurso($evento)
    {
      $sql = "SELECT
            t3.sg_instituicao_ies as instituicao,
            t1.cd_curso_cur as cod_curso,
            t2.nm_abrev_curso_cur||' - '||t4.nm_campus_cam as curso,
            COUNT(*) as total,
            COUNT(t5.cd_candidato_can) filter (where t5.fl_homologado_can = true) as homologados
        from
            processos_seletivos.opcao_candidato_opc t0
            inner join processos_seletivos.curso_evento_cue t1 on (t0.cd_curso_evento_cue = t1.cd_curso_evento_cue)
            inner join processos_seletivos.curso_cur t2 on (t1.cd_curso_cur = t2.cd_curso_cur)
            inner join processos_seletivos.instituicao_ensino_superior_ies t3 on (t2.cd_instituicao_ies = t3.cd_instituicao_ies)
            inner join processos_seletivos.campus_cam t4 on (t2.cd_campus_cam = t4.cd_campus_cam)
            inner join processos_seletivos.candidato_can t5 on t0.cd_candidato_can = t5.cd_candidato_can
        where
            t1.cd_evento_eve  = {$evento}
        AND t0.nu_opcao_opc = '1'
        group by
            t3.sg_instituicao_ies,
            t1.cd_curso_cur,
            t2.nm_abrev_curso_cur||' - '||t4.nm_campus_cam
        ORDER BY total desc";

        return collect(DB::connection('pgsql')->select($sql));

    }


    public function getCandidatoVaga($evento, $categoria, $quebra, $instituicao)
    {

        $nomeCurso = "";
        $order = "";
        if($quebra){
            $nomeCurso = " t2.nm_abrev_curso_cur";
            $order = ", t4.nm_campus_cam order by t4.nm_campus_cam, curso";
        }else{
            $nomeCurso = " t2.nm_abrev_curso_cur||' - '||t4.nm_campus_cam";
            $order = ", t4.nm_campus_cam order by $nomeCurso";
        }

        $sql="";
        switch ($categoria) {
            case 100:
                $sql = "SELECT
                            t0.cd_curso_cur as cod_curso,
                            $nomeCurso as curso,
                            t4.nm_campus_cam,
                            t0.nu_vagas_cue as  vagas,
                            COUNT(t5.cd_candidato_can) filter (where t5.fl_homologado_can = true and t1.nu_opcao_opc = '1') as opcao1,
                            COUNT(t5.cd_candidato_can) filter (where t5.fl_homologado_can = true and t1.nu_opcao_opc = '1A') as opcao1A
                        from
                            processos_seletivos.curso_evento_cue t0
                            left join processos_seletivos.opcao_candidato_opc t1 on (t0.cd_curso_evento_cue = t1.cd_curso_evento_cue)
                            inner join processos_seletivos.curso_cur t2 on (t0.cd_curso_cur = t2.cd_curso_cur and t2.cd_instituicao_ies = $instituicao)
                            inner join processos_seletivos.campus_cam t4 on (t2.cd_campus_cam = t4.cd_campus_cam)
                            left join processos_seletivos.candidato_can t5 on t1.cd_candidato_can = t5.cd_candidato_can
                        where
                            t0.cd_evento_eve  = $evento
                        group by
                            t0.cd_curso_cur,
                            $nomeCurso,
                            t0.nu_vagas_cue
                                $order";
            break;
            case 200:
                $sql = "SELECT
                            t0.cd_curso_cur as cod_curso,
                            $nomeCurso as curso,
                            t4.nm_campus_cam,
                            t7.nu_vagas_originais_cuc as vagas,
                            COUNT(t5.cd_candidato_can) filter (where t5.fl_homologado_can = true and t1.nu_opcao_opc = '1') as opcao1,
                            COUNT(t5.cd_candidato_can) filter (where t5.fl_homologado_can = true and t1.nu_opcao_opc = '1A') as opcao1A
                        from
                            processos_seletivos.curso_evento_cue t0
                            left join processos_seletivos.opcao_candidato_opc t1 on (t0.cd_curso_evento_cue = t1.cd_curso_evento_cue)
                            inner join processos_seletivos.curso_cur t2 on (t0.cd_curso_cur = t2.cd_curso_cur and t2.cd_instituicao_ies = $instituicao)
                            inner join processos_seletivos.campus_cam t4 on (t2.cd_campus_cam = t4.cd_campus_cam)
                            left join processos_seletivos.candidato_can t5 on t1.cd_candidato_can = t5.cd_candidato_can
                            inner join processos_seletivos.categoria_evento_cae t6 on t6.cd_categoria_cat =3
                            inner join processos_seletivos.curso_categoria_cuc t7 on t6.cd_categoria_evento_cae = t7.cd_categoria_evento_cae and t1.cd_curso_evento_cue = t7.cd_curso_evento_cue
                        where
                            t0.cd_evento_eve  = $evento
                        group by
                            t0.cd_curso_cur,
                            $nomeCurso,
                            t7.nu_vagas_originais_cuc
                                $order";
            break;

            default:
                if($quebra){
                    $nomeCurso = " t0.nm_abrev_curso_cur";
                    $order = ", t0.nm_campus_cam  order by t0.nm_campus_cam, curso";
                }else{
                    $nomeCurso = " t0.nm_abrev_curso_cur||' - '||t0.nm_campus_cam";
                    $order = ", t0.nm_campus_cam  order by $nomeCurso";
                }
                $sql = "SELECT
                            t0.cd_curso_cur as cod_curso,
                            $nomeCurso as curso,
                            t0.nm_campus_cam,
                            t0.nu_vagas_originais_cuc as vagas,
                            COUNT(t2.cd_candidato_can) filter (where t2.fl_homologado_can = true and t1.nu_opcao_opc = '1' and t3.cd_categoria_evento_cae = t2.cd_categoria_evento_cae) as opcao1,
                            COUNT(t2.cd_candidato_can) filter (where t2.fl_homologado_can = true and t1.nu_opcao_opc = '1A' and t3.cd_categoria_evento_cae = t2.cd_categoria_evento_cae) as opcao1A
                        from
                            processos_seletivos.instituicao_curso_categoria_vw t0
                            inner join processos_seletivos.opcao_candidato_opc t1 on (t0.cd_curso_evento_cue = t1.cd_curso_evento_cue)
                            inner join processos_seletivos.candidato_can t2 on t2.cd_candidato_can = t1.cd_candidato_can
                            left JOIN processos_seletivos.categoria_evento_cae t3 ON t3.cd_categoria_evento_cae = t2.cd_categoria_evento_cae and t3.cd_categoria_cat = $categoria

                            where
                            t0.cd_evento_eve  = $evento
                            and cd_instituicao_ies = $instituicao
                            and t0.cd_categoria_cat = $categoria

                            group by
                            t0.cd_curso_cur,
                            $nomeCurso,
                            t0.nu_vagas_originais_cuc
                            $order
                            ";
            break;
        }


        return collect(DB::connection('pgsql')->select($sql));
    }

}
