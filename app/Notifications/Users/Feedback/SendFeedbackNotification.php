<?php

namespace App\Notifications\Users\Feedback;

use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendFeedbackNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public array $feedback)
    {
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
            ->subject(Page::FEEDBACK_TYPES_TEXT[$this->feedback['type']])
            ->line(Page::FEEDBACK_TYPES_TEXT[$this->feedback['type']])
            ->from(config('mail.from.address'), $this->feedback['name'])
            ->line(
                'User: ' . $this->feedback['name'] . ' / Phone: ' . $this->feedback['phone'] . ' / Email: ' . $this->feedback['email']
            )
            ->line($this->feedback['comment']);
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
