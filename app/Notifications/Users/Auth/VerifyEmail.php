<?php

namespace App\Notifications\Users\Auth;

use App\Models\EmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public EmailVerification $emailVerify)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage())
                ->subject('KayPro - завершение регистрации')
                ->greeting('Уважаемый(ая) '.$this->emailVerify->user->first_name)
                ->line(
                        'Для завершения регистрации в KayPro введите на форме регистрации проверочный код: '.$this->emailVerify->verification_code
                )
                ->salutation('С уважением, команда KayPro');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            //
        ];
    }
}
