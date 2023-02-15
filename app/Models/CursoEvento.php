<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CursoEvento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.curso_evento_cue';
    protected $primaryKey = 'cd_curso_evento_cue';

    protected $fillable = ['nm_curso_cur'];

    public function curso()
    {
        return $this->belongsTo('App\Models\Curso', 'cd_curso_cur', 'cd_curso_cur');
    }

    public function evento()
    {
        return $this->has('App\Models\Evento', 'cd_evento_eve', 'cd_evento_eve');
    }

    public function categorias() {
        $this->hasMany(CategoriaEvento::class, 'cd_categoria_evento_cae', 'cd_categoria_evento_cae');
    }

    public function pesoCorte()
    {
        return $this->hasMany(PesoCorte::class, 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

    public function cursoCategoria()
    {
        return $this->hasMany(CursoCategoria::class, 'cd_curso_evento_cue', 'cd_curso_evento_cue');
    }

}
