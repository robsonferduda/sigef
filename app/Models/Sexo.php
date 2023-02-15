<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'pessoa.sexo_sex';
	protected $primaryKey = 'cd_sexo_sex';

    protected $fillable = ['nm_sexo_sex'   					   
    					  ]; //whitelist de inserção

    public $timestamps = false;
}