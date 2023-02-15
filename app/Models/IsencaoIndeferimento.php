<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsencaoIndeferimento extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.isencao_indeferimento_isi';
	protected $primaryKey = 'cd_isencao_indeferimento_isi';
    protected $fillable = ['nm_indeferimento_isi']; 
    public $timestamps = true;
}
