<?php

use App\Models\EmailVerification;
use App\Models\PasswordRecovery;

if (!function_exists('create4DigitCodeForPasswordRecovery')) {
    /**
     * @return int
     * @throws Exception
     */
    function create4DigitCodeForPasswordRecovery(): int
    {
        do {
            $code = random_int(1000, 9999);
        } while (PasswordRecovery::query()->where('verification_code', $code)->whereNull('recovered_at')->exists());
        return $code;
    }
}

if (!function_exists('create4DigitCodeForEmailVerify')) {
    /**
     * @return int
     * @throws Exception
     */
    function create4DigitCodeForEmailVerify(): int
    {
        do {
            $code = random_int(1000, 9999);
        } while (EmailVerification::query()->where('verification_code', $code)->whereNull('verified_at')->exists());
        return $code;
    }
}
