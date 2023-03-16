<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.sala_sal';
    protected $primaryKey = 'cd_sala_sal';

    protected $fillable = ['cd_tipo_sala_tis', 'nu_carteiras_sal', 'cd_tipo_carterira_tic', 'nm_sala_sal', 'cd_pavimento_pav'];

    public $timestamps = false;

    public function pavimento()
    {
        return $this->hasOne(Pavimento::class, 'cd_pavimento_pav', 'cd_pavimento_pav');
    }

    public function tipoSala()
    {
        return $this->hasOne(TipoSala::class, 'cd_tipo_sala_tis', 'cd_tipo_sala_tis');
    }

    public function tipoCarteira()
    {
        return $this->hasOne(TipoCarteira::class, 'cd_tipo_carteira_tic', 'cd_tipo_carteira_tic');
    }

}
