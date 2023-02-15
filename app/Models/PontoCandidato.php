<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoCandidato extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.ponto_candidato_ptc';
    protected $primaryKey = 'cd_ponto_candidato_ptc';

    protected $fillable = [
        'cd_candidato_can',
        'cd_opcao_candidato_opc',
        'nu_peso_ptg_ptc',
        'nu_peso_lle_ptc',
        'nu_peso_mtm_ptc',
        'nu_peso_blg_ptc',
        'nu_peso_chs_ptc',
        'nu_peso_fsc_ptc',
        'nu_peso_qmc_ptc',
        'nu_nota_peso_redacao_ptc',
        'nu_nota_peso_discursiva_ptc'
    ]; //whitelist de inserção

    public $timestamps = false;

    public function candidato(){
        return $this->hasOne('App\Models\Candidato','cd_candidato_can','cd_candidato_can');
    }
}
