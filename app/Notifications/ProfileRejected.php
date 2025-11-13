<?php

namespace App\Notifications;

use App\Models\PlwdProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileRejected extends Notification
{
    use Queueable;

    protected $profile;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(PlwdProfile $profile, ?string $reason = null)
    {
        $this->profile = $profile;
        $this->reason = $reason;
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
        $mail = (new MailMessage)
            ->subject('Profile Review - V-PeSDI PLWDs Database')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for registering with V-PeSDI PLWDs Database.')
            ->line('After reviewing your profile, we need you to make some updates before we can approve it.');

        if ($this->reason) {
            $mail->line('**Reason:** ' . $this->reason);
        }

        return $mail
            ->line('Please update your profile with the correct information and resubmit for verification.')
            ->action('Update Profile', url('/plwd/profile/edit'))
            ->line('If you have any questions, please contact our support team.')
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
            'message' => 'Your profile needs attention',
            'reason' => $this->reason,
        ];
    }
}
