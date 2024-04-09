<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserAttributes
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;

        // Generate username from first and last name
        $user->username = strtolower($user->firstname . $user->lastname[0]);

        // Generate profile image placeholder using initials
        $initials = strtoupper($user->firstname[0] . $user->lastname[0]);
        $user->profile_image = "https://ui-avatars.com/api/?name=$initials&color=7F9CF5&background=EBF4FF&size=256";

        $user->save();
    }
}
