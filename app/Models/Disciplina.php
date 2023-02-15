<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.disciplina_dis';
	protected $primaryKey = 'cd_disciplina_dis';

    protected $fillable = [
                            'cd_evento_eve',
                            'nu_disciplina_dis',
                            'nm_disciplina_dis',
                            'sg_disciplina_dis',
                            'nu_questao_inicial_dis',
                            'nu_questao_final_dis',
                            'cd_prova_pro'
                        ]; //whitelist de inserção

    public $timestamps = true;
}
