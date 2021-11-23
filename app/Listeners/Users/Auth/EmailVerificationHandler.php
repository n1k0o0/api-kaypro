<?php

namespace App\Listeners\Users\Auth;

use App\Events\Users\Auth\Registered;
use App\Models\EmailVerification;
use Exception;

class EmailVerificationHandler
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
     * @param  Registered  $event
     * @return void
     * @throws Exception
     */
    public function handle(Registered $event): void
    {
        if ($event->user->isNotVerified()) {
            /** @var EmailVerification $emailVerification */
            $emailVerification = $event->user->emailVerifications()->create([
                    'user_id' => $event->user->id,
                    'email' => $event->user->email,
                    'verification_code' => create4DigitCodeForEmailVerify(),
            ]);

            $event->user->notifyByEmailVerification($emailVerification);

            $emailVerification->sent_at = now();
            $emailVerification->save();
        }
    }
}
