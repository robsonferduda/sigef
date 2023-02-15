<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesoCorte extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_peso_corte_cpc';
    protected $primaryKey = 'cd_curso_peso_corte_cpc';

    protected $fillable = []; //whitelist de inserção

    public $timestamps = false;

    public function disciplina()
    {
        return $this->hasOne(Disciplina::class, 'cd_disciplina_dis', 'cd_disciplina_dis');
    }

}