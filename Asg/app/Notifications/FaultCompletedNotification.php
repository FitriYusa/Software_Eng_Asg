<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // optional, use if you want queue
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FaultReport;

class FaultCompletedNotification extends Notification 
{
   
   
    protected $fault;

    public function __construct(FaultReport $fault)
    {
        $this->fault = $fault;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // send via email + save in DB
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Fault Report Has Been Completed')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("Your reported fault '{$this->fault->description}' has been marked as completed by the technician.")
            ->action('View Fault Report', url('/faults/' . $this->fault->id))
            ->line('Thank you for using our Fault Report System!');
    }

    public function toArray($notifiable)
    {
        return [
            'fault_id' => $this->fault->id,
            'message'  => "Your fault '{$this->fault->description}' has been completed.",
        ];
    }
}
