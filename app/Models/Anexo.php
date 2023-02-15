<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anexo extends Model
{
    use SoftDeletes;

    protected $table = 'processos_seletivos.anexo_ane';

    protected $primaryKey = 'cd_anexo_ane';

    protected $fillable = [
        'nm_anexo_ane', 'dc_caminho_ane', 'cd_tipo_anexo_tia', 'cd_candidato_can'
    ]; //whitelist de inserção

    public $timestamps = true;
}