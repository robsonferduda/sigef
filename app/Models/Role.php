<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends LaratrustRole implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($role) {
            
            //Implementar 

        });

    }
}