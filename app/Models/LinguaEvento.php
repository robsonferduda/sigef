<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinguaEvento extends Model
{
    protected $connection = 'pgsql';
	protected $table = 'processos_seletivos.lingua_evento_lie';

	protected $primaryKey = 'cd_lingua_evento_lie';

    protected $fillable = [
                            'cd_lingua_lin',
                            'cd_evento_eve',
                            'fl_primeira_lingua_lie',
                            'fl_segunda_lingua_lie',
                            'fl_libras_lie'
                        ]; //whitelist de inserção

    public $timestamps = false;

    public function lingua()
    {
        return $this->hasOne('App\Models\Lingua', 'cd_lingua_lin', 'cd_lingua_lin');
    }

    public function tipoProva()
    {
        return $this->belongTo('App\Models\TipoProva', 'cd_lingua_evento_lie', 'cd_lingua_evento_lie');
    }
}