<?php

namespace App\Notifications\Cleaner\Proposal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\OrderProposal;

class Rejected extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $order_proposal;
    public function __construct(OrderProposal $order_proposal)
    {
        $this->order_proposal = $order_proposal;
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
        $url = url('/api');
        return (new MailMessage)
            ->line('You are receiving this email because the customer has rejected your proposal.')
            ->action('Proposal Rejected', url($url));
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

     public function toDatabase($notifiable)
    {
        return [
           'order_proposal' => $this->order_proposal->load(array('customer','order','status','cleaner')),
        ];
   
    }
}
