<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pavimento extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.pavimento_pav';
    protected $primaryKey = 'cd_pavimento_pav';

    protected $fillable = ['cd_bloco_setor_bls', 'nm_pavimento_pav'];

    public $timestamps = false;

    public function bloco()
    {
        return $this->hasOne(Bloco::class, 'cd_bloco_setor_bls', 'cd_bloco_setor_bls');
    }

    public function salas()
    {
        return $this->hasMany(Sala::class, 'cd_pavimento_pav', 'cd_pavimento_pav');
    }
}
