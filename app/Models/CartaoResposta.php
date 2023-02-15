<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CartaoResposta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.cartao_resposta_car';
    protected $primaryKey = 'cd_cartao_resposta_car';
    public $timestamps = true;

    protected $fillable = ['cd_candidato_can', 'cd_prova_pro', 'fl_faltante_car', 'cd_resposta_car', 'nu_hora_termino_car', 'nu_min_termino_car', 'nu_lote_car'];

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

    public function cartaoCriticado($prova, $candidato) {
        return $this->where('cd_prova_pro', $prova)->where('cd_candidato_can', $candidato)->first()->toArray();
    }
}

