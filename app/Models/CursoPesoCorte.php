<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoPesoCorte extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_peso_corte_cpc';
    protected $primaryKey = 'cd_curso_peso_corte_cpc';

    protected $fillable = [
        'cd_evento_eve',
        'nu_corte_cpc',
        'nu_peso_cpc',
        'cd_curso_evento_cue',
        'nu_disciplina_dis'

    ]; //whitelist de inserção

    public $timestamps = true;
}
