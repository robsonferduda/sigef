<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'processos_seletivos.endereco_end';

    protected $primaryKey = 'cd_endereco_end';

    protected $fillable = [
        'nm_logradouro_end',
        'nu_numero_end',
        'nm_complemento_end',
        'nm_bairro_end',
        'nu_cep_end',
        'fl_principal_end',
        'cd_candidato_can',
        'cd_evento_eve',
        'cd_localidade_end',
        'nm_cidade_end',
        'sg_estado_end'
    ]; //whitelist de inserção

    public $timestamps = true;
}
