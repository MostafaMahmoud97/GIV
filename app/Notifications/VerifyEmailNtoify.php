<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNtoify extends Notification
{
    use Queueable;


    public $url;
    public $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url,$name)
    {
        $this->url = $url;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->from('info@addgrouptech.com','GIV')
            ->line('Verify Email')
            ->line("Hello ".$this->name)
            ->line("You Can Verify Your Email From Here")
            ->action('Click To Verify', $this->url)
            ->line('Thank you for using GIV APP!');
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
            //
        ];
    }
}
