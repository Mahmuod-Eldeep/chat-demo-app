<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;



class UpdateUserStatus
{

    /**
     * Handle the event.
     */
    public function handle(Login  $event): void
    {
        $user = $event->user;
        $user->is_online = true;
        $user->save();
    }
}
