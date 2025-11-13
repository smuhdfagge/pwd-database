<?php

namespace App\Notifications;

use App\Models\PlwdProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileApproved extends Notification
{
    use Queueable;

    protected $profile;

    /**
     * Create a new notification instance.
     */
    public function __construct(PlwdProfile $profile)
    {
        $this->profile = $profile;
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
            ->subject('Profile Approved - V-PeSDI PLWDs Database')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Congratulations! Your profile has been verified and approved.')
            ->line('You now have full access to all features and benefits of the V-PeSDI PLWDs Database.')
            ->action('View Your Profile', url('/plwd/dashboard'))
            ->line('Thank you for registering with us!')
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
            'profile_id' => $this->profile->id,
            'message' => 'Your profile has been approved',
        ];
    }
}
