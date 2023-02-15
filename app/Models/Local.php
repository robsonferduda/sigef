<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.local_prova_lop';
	protected $primaryKey = 'cd_local_prova_lop';

    protected $fillable = []; 

    public $timestamps = false;
}
