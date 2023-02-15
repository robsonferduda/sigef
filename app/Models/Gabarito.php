<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gabarito extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.gabarito_gab';
    protected $primaryKey = 'cd_gabarito_gab';

    protected $fillable = [
        'cd_prova_pro',
        'cd_tipo_prova_tip',
        'nu_questao_gab',
        'nu_proposicoes_gab',
        'nu_resposta_gab',
        'fl_anulada_gab'
    ]; //whitelist de inserção

    public $timestamps = true;

    public function prova(){
        return $this->hasOne('App\Models\Prova', 'cd_prova_pro', 'cd_prova_pro');
    }

    public function tipoProva(){
        return $this->hasOne('App\Models\TipoProva', 'cd_tipo_prova_tip', 'cd_tipo_prova_tip');
    }
}
