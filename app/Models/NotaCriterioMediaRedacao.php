<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaCriterioMediaRedacao extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.nota_criterio_media_redacao_ncr';
    protected $primaryKey = 'cd_nota_criterio_redacao_ncr';

    public $timestamps = false;

    protected $fillable = [ 'cd_candidato_can',
                            'nu_nota_criterio_a_ncr',
                            'nu_nota_criterio_b_ncr',
                            'nu_nota_criterio_c_ncr',
                            'nu_nota_criterio_d_ncr',
                            'nu_nota_final_ncr',
                            'cd_motivo_zero_ncr',
                          ];

    public function candidato() {
        return $this->hasOne(Candidato::class, 'cd_candidato_can', 'cd_candidato_can');
    }
}
