<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.setor_sel';
	protected $primaryKey = 'cd_setor_sel';

    protected $fillable = []; 

    public $timestamps = false;
}
