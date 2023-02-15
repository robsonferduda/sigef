<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model 
{
	protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.pagamento_pag';
	protected $primaryKey = 'cd_pagamento_pag';
	protected $fillable	 = [];
}