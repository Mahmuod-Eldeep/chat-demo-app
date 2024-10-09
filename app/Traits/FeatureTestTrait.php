<?php

namespace App\Traits;

use App\Models\User;

trait FeatureTestTrait
{
    /**
     *  Create an authorized User.
     */


    public function authorized_user(): object
    {
        $user = User::factory()->create();

        return $this->actingAs($user);
    }
}
