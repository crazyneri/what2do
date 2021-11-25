<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    use Queueable;

    private $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($search_session)
    {
        $this->session = $search_session;
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
        // dd($notifiable);
        // $url = url('/search/'.$this->session->id);
        // $url = url('/search/'.$this->session->id);
        $url = url('/search');
        // $session_data = $this->session->searched_date);

        return (new MailMessage)
                    ->subject('The fun can begin!')
                    ->line('Your friend has started a session on: ' .$this->session->searched_date . '.')
                    ->action('Join now', $url)
                    ->line('Have a good time.');
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
