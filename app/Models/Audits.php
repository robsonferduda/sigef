<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audits extends Model implements \OwenIt\Auditing\Contracts\Audit
{    
    use \OwenIt\Auditing\Audit;

    protected $table = 'audits';
    protected $primaryKey = 'id';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'old_values'   => 'json',
        'new_values'   => 'json',
        // Note: Please do not add 'auditable_id' in here, as it will break non-integer PK models
    ];

    protected $fillable = [
        'event', 'auditable_type', 'user_type', 'auditable_id', 'user_id', 'old_values', 'new_values','user_agent', 'url', 'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function evento()
    {
        return $this->belongsTo('App\Models\EventoAuditoria', 'event', 'ds_chave_eva');
    }

    public function sistema()
    {
        return $this->belongsTo('App\Models\Sistema', 'cd_sistema_sis', 'ds_sigla_sis');
    }

    public function getTotais()
    {
        $total_atividades = DB::select(DB::raw("select date_trunc('day', created_at) as data, 
        count(created_at) as total
        from audits
        group by data
        order by data"));

        return $total_atividades;
    }

    public function getTotaisUsuario($id)
    {
        $total_atividades = DB::select(DB::raw("select date_trunc('day', created_at) as data, 
        count(created_at) as total
        from audits
        where user_id = $id
        group by data
        order by data"));

        return $total_atividades;
    }

    //Atualiza o registo de auditorias com o Id do sistema
    protected static function booted()
    {
        static::created(function ($audits) {

            if(!$audits->user_id) $audits->user_id = Session::get('user_update');
            
            $audits->cd_sistema_sis = env('APP_ID');
            $audits->save();
        });
    }
}