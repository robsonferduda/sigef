<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banheiro extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.banheiro_ban';
    protected $primaryKey = 'cd_banheiro_ban';

    protected $fillable = ['nm_banheiro_ban', 'cd_pavimento_pav', 'fl_adaptado_ban', 'nu_cabines_ban'];

    public $timestamps = false;

    public function pavimento()
    {
        return $this->hasOne(Pavimento::class, 'cd_pavimento_pav', 'cd_pavimento_pav');
    }

}
