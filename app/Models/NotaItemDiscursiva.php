<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaItemDiscursiva extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.nota_item_discursiva_nid';
    protected $primaryKey = 'cd_nota_item_discursiva_nid';

    protected $fillable = [ 'cd_candidato_can',
                            'nu_questao_nid',
                            'nu_correcao_nid',
                            'nu_nota_nid',
                            'nu_professor_nid',
                            'cd_motivo_zero_nid',
                            'nu_nota_item_a_nid',
                            'nu_nota_item_b_nid',
                            'nu_nota_item_c_nid',
                            'nu_nota_item_d_nid',
                            'nu_nota_item_e_nid',
                            'nu_nota_item_f_nid',
                            'nu_nota_item_g_nid'
                          ];

    public function candidato() {
        return $this->hasOne(Candidato::class, 'cd_candidato_can', 'cd_candidato_can');
    }

}
