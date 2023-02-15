<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raca extends Model
{

    protected $connection = 'pgsql';
	protected $table = 'pessoa.raca_rac';
	protected $primaryKey = 'cd_raca_rac';

    protected $fillable = ['nm_raca_rac']; 

    public $timestamps = false;
}