<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProva extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.tipo_prova_tip';
    protected $primaryKey = 'cd_tipo_prova_tip';

    protected $fillable = [
        'cd_evento_eve',
        'cd_prova_pro',
        'cd_lingua_evento_lie',
        'nu_tipo_tip',
        'sg_tipo_tip',
        'nm_tipo_tip'
    ]; //whitelist de inserção

    public $timestamps = true;

    public function linguaEvento()
    {
        return $this->hasOne('App\Models\LinguaEvento', 'cd_lingua_evento_lie', 'cd_lingua_evento_lie');
    }

    public function prova()
    {
        return $this->hasOne('App\Models\Prova', 'cd_prova_pro', 'cd_prova_pro');
    }
}
