<?php

namespace App\Notifications;

use App\Models\Opportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOpportunityNotification extends Notification
{
    use Queueable;

    protected $opportunity;

    /**
     * Create a new notification instance.
     */
    public function __construct(Opportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $opportunityUrl = url('/opportunities/' . $this->opportunity->id);
        
        $mail = (new MailMessage)
            ->subject('New Opportunity: ' . $this->opportunity->title)
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('A new opportunity has been posted on V-PeSDI PLWDs Database that may interest you.')
            ->line('**' . $this->opportunity->title . '**')
            ->line('**Type:** ' . ucfirst($this->opportunity->type));

        if ($this->opportunity->organization) {
            $mail->line('**Organization:** ' . $this->opportunity->organization);
        }

        if ($this->opportunity->location) {
            $mail->line('**Location:** ' . $this->opportunity->location);
        }

        if ($this->opportunity->deadline) {
            $mail->line('**Deadline:** ' . $this->opportunity->deadline->format('F j, Y'));
        }

        $mail->line('**Description:**')
            ->line(substr($this->opportunity->description, 0, 200) . (strlen($this->opportunity->description) > 200 ? '...' : ''))
            ->action('View Full Details', $opportunityUrl)
            ->line('Don\'t miss out on this opportunity!')
            ->salutation('Best regards, V-PeSDI Team')
            ->with([
                'logoUrl' => asset('images/vpesdilogo.jpg')
            ]);

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'opportunity_id' => $this->opportunity->id,
            'title' => $this->opportunity->title,
            'type' => $this->opportunity->type,
        ];
    }
}
