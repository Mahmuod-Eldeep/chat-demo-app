<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UpdateLastSeenOnLogout
{

    /**
     * Handle the event.
     */
    public function handle(Logout  $event): void
    {
        $user = Auth::user();
        if ($user) {
            $user->last_seen = now();
            $user->save();
        }
    }
}
