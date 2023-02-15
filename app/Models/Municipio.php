<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'util.municipio_mun';
	protected $primaryKey = 'cd_municipio_mun';

    public $timestamps = false;

    protected $fillable = [
                            'nm_municipio_mun',
                            'cd_unidade_federacao_unf'
    					   ];

}
