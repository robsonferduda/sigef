<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoCandidatoAcertos extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.ponto_candidato_acertos_pca';
    protected $primaryKey = 'cd_ponto_candidato_acertos_pca';

    protected $fillable = [
        'cd_candidato_can',
        'nu_acertos_ptg_pca',
        'nu_acertos_lle_pca',
        'nu_acertos_mtm_pca',
        'nu_acertos_blg_pca',
        'nu_acertos_chs_pca',
        'nu_acertos_fsc_pca',
        'nu_acertos_qmc_pca',
        'nu_nota_redacao_pca',
        'nu_nota_discursiva_1_pca',
        'nu_nota_discursiva_2_pca',
        'nu_nota_discursiva_3_pca',
        'nu_nota_discursiva_4_pca',
        'fl_faltante_prova_1_pca',
        'fl_faltante_prova_2_pca'
    ]; //whitelist de inserção

    public $timestamps = true;

    public function candidato(){
        return $this->hasOne('App\Models\Candidato','cd_candidato_can','cd_candidato_can');
    }
}
