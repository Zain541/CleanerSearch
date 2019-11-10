<?php

namespace App\Notifications\Cleaner\Proposal;

use App\OrderProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Approved extends Notification
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
            ->action('Proposal Approved', url($url));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
           'order_proposal' => $this->order_proposal->load(array('customer','order','status','cleaner')),
        ];
   
    }
}