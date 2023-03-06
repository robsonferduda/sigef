<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.bloco_setor_bls';
    protected $primaryKey = 'cd_bloco_setor_bls';

    protected $fillable = ['cd_setor_set',
        'nm_endereco_acesso_bls',
        'fl_muro_bls',
        'fl_guarita_bls',
        'fl_elevador_bls',
        'fl_portao_bls',
        'fl_rampa_bls',
        'fl_vigilancia_bls',
        'fl_monitoramento_bls',
        'fl_estacionamento_bls',
        'fl_wifi_bls',
        'nm_bloco_bls'];

    public $timestamps = false;

    public function setor()
    {
        return $this->hasOne(Setor::class, 'cd_setor_set', 'cd_setor_set');
    }
}
