<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lingua extends Model
{
	protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.lingua_lin';

	protected $primaryKey = 'cd_lingua_lin';

    protected $fillable = [
                            'cd_lingua_lin',
                            'nm_lingua_lin'
                        ]; //whitelist de inserção

    public $timestamps = false;

    public function linguaEvento()
    {
        return $this->belongsTo(LinguaEvento::class, 'cd_lingua_lin', 'cd_lingua_lin');
    }
}
