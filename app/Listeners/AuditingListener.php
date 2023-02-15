<?php

namespace App\Listeners;

use OwenIt\Auditing\Events\Auditing;

class AuditingListener
{
    public function __construct()
    {
    
    }

    public function handle(Auditing $event)
    {
        $event->user_id = 21;
        dd($event);
    }

    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Auditing',
            'App\Listeners\AuditingListener@handle'
        );
    }
}