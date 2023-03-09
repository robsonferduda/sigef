<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{

    protected $connection = 'pgsql';
    protected $table = 'espaco_fisico.local_prova_lop';
    protected $primaryKey = 'cd_local_prova_lop';

    protected $fillable = ['cd_estado_est', 'cd_local_prova_lop', 'nm_local_prova_lop'];

    public $timestamps = false;

    public function estado()
    {
        return $this->hasOne(Estado::class, 'cd_estado_est', 'cd_estado_est');
    }

    public function setores()
    {
        return $this->hasMany(Setor::class, 'cd_local_prova_lop', 'cd_local_prova_lop');
    }
}