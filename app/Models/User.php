<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'pessoa.usuario_login_usl';
	protected $primaryKey = 'cd_usuario_login_usl';
	protected $fillable = ['senha_usl']; 
}