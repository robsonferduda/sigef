<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaItemMediaDiscursiva extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.nota_item_media_discursiva_nim';
    protected $primaryKey = 'cd_nota_item_media_discursiva_nim';

    public $timestamps = false;

    protected $fillable = [ 'cd_candidato_can',
                            'nu_questao_nim',
                            'nu_nota_final_nim',
                            'cd_motivo_zero_nim',
                            'nu_nota_item_a_nim',
                            'nu_nota_item_b_nim',
                            'nu_nota_item_c_nim',
                            'nu_nota_item_d_nim',
                            'nu_nota_item_e_nim',
                            'nu_nota_item_f_nim',
                            'nu_nota_item_g_nim'
                          ];

    public function candidato() {
        return $this->hasOne(Candidato::class, 'cd_candidato_can', 'cd_candidato_can');
    }

}
