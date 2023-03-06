<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.setor_set';
    protected $primaryKey = 'cd_setor_set';

    protected $fillable = ['cd_local_prova_lop', 'nm_abrev_setor_set', 'nm_setor_set', 'cd_rede_ensino_ree'];

    public $timestamps = false;

    public function local()
    {
        return $this->hasOne(Local::class, 'cd_local_prova_lop', 'cd_local_prova_lop');
    }

    public function redeEnsino()
    {
        return $this->hasOne(RedeEnsino::class, 'cd_rede_ensino_ree', 'cd_rede_ensino_ree');
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class, 'cd_setor_set', 'cd_setor_set');
    }
}
