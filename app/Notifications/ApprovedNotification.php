<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovedNotification extends Notification
{
    use Queueable;
    private $sender;
    private $leave;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, Leave $leave)
    {
        $this->sender=$user;
        $this->leave=$leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('hello '.$notifiable->fullname)
                    ->line('your leave has been approved')
                    ->line('for the date '.$this->leave->leave_on);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $notifiable->email.'leave approved date - '.$this->leave->leave_on
        ];
    }
}
