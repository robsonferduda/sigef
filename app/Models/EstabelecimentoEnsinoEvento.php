<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstabelecimentoEnsinoEvento extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.estabelecimento_ensino_evento_eee';
    protected $primaryKey = 'cd_estabelecimento_ensino_evento_eee';

    public $timestamps = false;

    protected $fillable = [
        'cd_estabelecimento_ensino_ese',
        'cd_evento_eve'
    ];

    public function estabelecimento() {
        return $this->hasOne(EstabelecimentoEnsino::class, 'cd_estabelecimento_ensino_ese', 'cd_estabelecimento_ensino_ese');
    }
}
