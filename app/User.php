<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use LaratrustUserTrait;
    use Notifiable;

    protected $connection = 'pgsql_perfil';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','cd_funcao_fun','cd_departamento_dep','fl_active','cd_sexo_sex', 'cpf','senha_usl'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function funcao()
    {
        return $this->belongsTo('App\Models\Funcao', 'cd_funcao_fun', 'cd_funcao_fun');
    }

    public function departamento()
    {
        return $this->belongsTo('App\Models\Departamento', 'cd_departamento_dep', 'cd_departamento_dep');
    }

    public function getPermissionsRole()
    {
        if(count($this->roles)){
            foreach($this->roles as $role){
                foreach($role->permissions as $p){
                    $permissions_role[] = $p->id;
                }
            }
            return $permissions_role;
        }

        return array();
    }

    //Atualiza o registo de auditorias com o Id do sistema
    protected static function booted()
    {
        static::updated(function ($user) {
            Session::put('user_update', $user->id);            
        });

        static::updating(function ($user) {
            Session::put('user_update', $user->id);            
        });
    }
}