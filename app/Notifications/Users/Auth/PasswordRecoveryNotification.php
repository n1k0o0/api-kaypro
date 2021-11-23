<?php

namespace App\Notifications\Users\Auth;

use App\Models\PasswordRecovery;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordRecoveryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private PasswordRecovery $passwordRecovery)
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
                ->subject('KayPro - восстановление пароля')
                ->greeting('Уважаемый(ая) '.$this->passwordRecovery->user->first_name)
                ->line(
                        'Для восстановления пароля на KayPro введите в форме подтверждения проверочный код: '.$this->passwordRecovery->verification_code
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
