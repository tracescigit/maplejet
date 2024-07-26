<?php

namespace App\Listeners;


use Laravel\Passport\Events\AccessTokenCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Passport\Token;

class StoreTokenInDatabase
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AccessTokenCreated $event)
    {
        // Retrieve the access token ID from the event
        $tokenId = $event->tokenId;

        // Fetch the access token instance from the database using the ID
        $accessToken = Token::find($tokenId);

        // Ensure the access token exists and belongs to a user
        if ($accessToken && $accessToken->user) {
            // Store the access token in the database
            $accessToken->user->tokens()->save($accessToken);
        }
    }
}
