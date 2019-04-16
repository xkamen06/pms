<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserInformationNotification.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserInformationNotification
 * @package App\Notifications
 */
class UserInformationNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param string $email
     *
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        return (new MailMessage)
                    ->line(trans('Notifications.UserInformation.login_information'))
                    ->line(trans('Notifications.UserInformation.email') . $this->email)
                    ->line(trans('Notifications.UserInformation.password') . $this->password)
                    ->line(trans('Notifications.UserInformation.change_password'))
                    ->action(trans('Notifications.UserInformation.go_to_system'), url('/'))
                    ->line(trans('Notifications.thank_you'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
