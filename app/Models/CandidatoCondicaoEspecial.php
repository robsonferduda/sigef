<?php

namespace App\Models;

use App\Enums\TipoAnexo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidatoCondicaoEspecial extends Model
{
    use SoftDeletes;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.candidato_condicao_especial_cce';
    protected $primaryKey = 'cd_candidato_condicao_especial_cce';

    protected $fillable = [
        'cd_candidato_can',
        'cd_situacao_condicao_especial_sce',
        'cd_evento_eve',
        'nm_outra_cce',
        'cd_condicao_especial_evento_cee',
        'cd_motivo_indeferimento_condicao_especial_mic',
        'cd_usuario_usu',
        'ds_complemento_cce'
    ]; 

    public $timestamps = true;

    public function condicaoEvento()
    {
        return $this->hasOne(CondicaoEspecialEvento::class, 'cd_condicao_especial_evento_cee', 'cd_condicao_especial_evento_cee');
    }

    public function situacao()
    {
        return $this->hasOne(SituacaoCondicaoEspecial::class, 'cd_situacao_condicao_especial_sce', 'cd_situacao_condicao_especial_sce');
    }

    public function usuario()
    {
        return $this->hasOne('App\User', 'id', 'cd_usuario_usu');
    }

    public function motivoIndeferimento()
    {
        return $this->hasOne(MotivoIndeferimentoCondicaoEspecial::class, 'cd_motivo_indeferimento_condicao_especial_mic', 'cd_motivo_indeferimento_condicao_especial_mic');
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'cd_candidato_can', 'cd_candidato_can')->where('cd_tipo_anexo_tia',TipoAnexo::CONDICAO);
    }
}