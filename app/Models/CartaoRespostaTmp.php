<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CartaoRespostaTmp extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.cartao_resposta_tmp_crt';
    protected $primaryKey = 'cd_cartao_resposta_tmp_crt';
    public $timestamps = true;

    protected $fillable = ['cd_candidato_can', 'cd_prova_pro', 'fl_faltante_crt', 'cd_resposta_crt', 'nu_hora_termino_crt', 'nu_min_termino_crt', 'nu_lote_crt'];

    public function candidato()
    {
        return $this->hasOne(Candidato::class, 'cd_candidato_can', 'cd_candidato_can');
    }

    public function lotes($evento)
    {
        return $this->whereHas('candidato' , function ($query) use ($evento){
            $query->where('cd_evento_eve', $evento);
        })->select('nu_lote_crt')->distinct()->orderby('nu_lote_crt')->pluck('nu_lote_crt')->toArray();
    }

    public function cartoesComCritica($evento, $inscricao, $lote)
    {
        return $this->with(['candidato' => function($query){
            $query->select('cd_candidato_can', 'nu_inscricao_can');
        }])->whereHas('candidato' , function ($query) use ($evento, $inscricao){
            $query->when($inscricao, function ($query) use ($inscricao){
                $query->where('nu_inscricao_can', $inscricao);
            });
            $query->where('cd_evento_eve', $evento);
        })->when($lote, function ($query) use ($lote){
            $query->where('nu_lote_crt', $lote);
        })->get()->sortBy('candidato.nu_inscricao_can')->toArray();
    }


}
