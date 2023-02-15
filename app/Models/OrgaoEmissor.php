<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgaoEmissor extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'pessoa.orgao_expeditor_ore';
	protected $primaryKey = 'cd_orgao_expeditor_ore';
    protected $fillable = ['nm_orgao_expeditor_ore', 'nm_sigla_ore'];

    public $timestamps = false;
}