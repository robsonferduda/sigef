<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.local_prova_lop';
    protected $primaryKey = 'cd_local_prova_lop';

    protected $fillable = ['cd_estado_est', 'cd_local_prova_lop', 'nm_local_prova_lop'];

    public $timestamps = false;

    public function estado()
    {
        return $this->hasOne(Estado::class, 'cd_estado_est', 'cd_estado_est');
    }

    public function setores()
    {
        return $this->hasMany(Setor::class, 'cd_local_prova_lop', 'cd_local_prova_lop');
    }

    public function getOcupacao()
    {
        $ocupacao =  DB::connection('pgsql')->select(DB::raw(" SELECT sum(nu_carteiras_sal) AS total_carteiras, 
        sum(nu_carteiras_evs) AS total_utilizado  
            FROM espaco_fisico.sala_sal t1
            JOIN espaco_fisico.pavimento_pav t2 ON t2.cd_pavimento_pav = t1.cd_pavimento_pav 
            JOIN espaco_fisico.bloco_setor_bls t3 ON t3.cd_bloco_setor_bls = t2.cd_bloco_setor_bls
            join espaco_fisico.setor_set t4 ON t4.cd_setor_set = t3.cd_setor_set 
            JOIN espaco_fisico.local_prova_lop t5 ON t5.cd_local_prova_lop = t4.cd_local_prova_lop 
            LEFT JOIN espaco_fisico.local_evento_loe t6 ON t6.cd_local_prova_lop = t5.cd_local_prova_lop 
            LEFT JOIN espaco_fisico.evento_espaco_fisico_eef t7 ON t7.cd_evento_eef = t6.cd_evento_eef 
            LEFT JOIN espaco_fisico.evento_sala_evs t8 ON t8.cd_sala_sal = t1.cd_sala_sal AND t8.cd_evento_eef = t7.cd_evento_eef AND t7.cd_evento_eve = 102 
            WHERE t6.cd_local_prova_lop = ".$this->cd_local_prova_lop))[0];

        return $ocupacao;
    }

    public function verificaLocal($evento, $local)
    {
        $sql = "SELECT count(*) AS total 
                FROM espaco_fisico.setor_evento_see t1 
                LEFT JOIN espaco_fisico.setor_set t2 ON t2.cd_setor_set = t1.cd_setor_set 
                LEFT JOIN espaco_fisico.local_prova_lop t3 ON t3.cd_local_prova_lop = t2.cd_local_prova_lop 
                WHERE t1.cd_evento_eef = $evento
                AND t2.cd_local_prova_lop = $local";

        return DB::connection('pgsql')->select(DB::raw($sql))[0]->total;
    }
}