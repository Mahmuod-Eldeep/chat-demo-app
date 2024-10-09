<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetUserStatus
{


    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $user = $event->user;
        if ($user) {
            $user->is_online = false;
            $user->save();
        }
    }
}
