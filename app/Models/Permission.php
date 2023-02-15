<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends LaratrustPermission implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $guarded = [];

    public function controle()
    {
        return $this->belongsTo('App\Models\Controle', 'cd_controle_con', 'cd_controle_con');
    }

    public function sistema()
    {
        return $this->belongsTo('App\Models\Sistema', 'cd_sistema_sis', 'cd_sistema_sis');
    }
}