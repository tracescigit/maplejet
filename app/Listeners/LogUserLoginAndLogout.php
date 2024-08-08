<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class LogUserLoginAndLogout
{
    /**
     * Handle the login event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handleLogin(Login $event)
    {
        $user = Auth::user();
        activity()->causedBy($user)
            ->withProperties([
                'name'  => $user->name,
                'email' => $user->email,
            ])
            ->event('login')
            ->log("User has logged in. Name: {$user->name}, Email: {$user->email}");
    }

    /**
     * Handle the logout event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handleLogout(Logout $event)
    {
        $user = Auth::user(); // Store user instance to avoid multiple calls

        activity()->causedBy($user)
            ->withProperties([
                'name'  => $user->name,
                'email' => $user->email,
            ])
            ->event('logout')
            ->log("User has logged out. Name: {$user->name}, Email: {$user->email}");
    }
}
