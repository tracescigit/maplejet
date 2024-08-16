<?php
namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Spatie\Activitylog\Facades\Activity;

class LogUserPasswordChange
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        Activity::causedBy($event->user)
            ->log('User changed their password');
    }
}
