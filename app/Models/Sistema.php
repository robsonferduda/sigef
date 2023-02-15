<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Sistema extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'sistema_sis';
    protected $primaryKey = 'cd_sistema_sis';

    protected $fillable = ['ds_sistema_sis', 'ds_sigla_sis'];


    public function permission()
    {
        return $this->hasMany('App\Models\Permission', 'cd_sistema_sis', 'cd_sistema_sis');
    }
}
