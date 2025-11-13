<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        return (new MailMessage)
            ->subject('Welcome to V-PeSDI PLWDs Database')
            ->greeting('Welcome, ' . $notifiable->name . '!')
            ->line('Thank you for registering with V-PeSDI PLWDs Database.')
            ->line('We are committed to empowering Persons Living With Disabilities by providing comprehensive support and opportunities.')
            ->line('**Next Steps:**')
            ->line('1. Complete your profile with accurate information')
            ->line('2. Upload supporting documents (ID Card, Medical Certificate, etc.)')
            ->line('3. Wait for admin verification (usually within 1-3 business days)')
            ->line('4. Once verified, you will have access to all benefits and programs')
            ->action('Complete Your Profile', url('/plwd/profile/edit'))
            ->line('If you have any questions, please don\'t hesitate to contact us.')
            ->salutation('Best regards, V-PeSDI Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Welcome to V-PeSDI PLWDs Database',
        ];
    }
}
