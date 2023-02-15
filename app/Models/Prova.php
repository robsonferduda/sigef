<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.prova_pro';
	protected $primaryKey = 'cd_prova_pro';

    protected $fillable = [
                            'cd_prova_pro',
                            'cd_evento_eve',
                            'nu_prova_pro',
                            'nm_prova_pro',
                            'qtd_questoes_pro'
                        ]; //whitelist de inserção

    public $timestamps = true;
}
