<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetorEvento extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.setor_evento_see';
    protected $primaryKey = 'cd_setor_evento_see';

    protected $fillable = [''];

    public function setor()
    {
        return $this->hasOne(Setor::class, 'cd_setor_set', 'cd_setor_set');
    }

}