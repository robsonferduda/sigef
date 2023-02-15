<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Campus extends Model implements Auditable
{    
    use \OwenIt\Auditing\Auditable;
    
    protected $connection = 'pgsql';
    protected $table = 'processos_seletivos.campus_cam';
    protected $primaryKey = 'cd_campus_cam';

    protected $fillable = ['nm_campus_cam'];

    public function curso(){
        return $this->belongsTo('App\Models\Curso', 'cd_campus_cam', 'cd_campus_cam');
    } 

}