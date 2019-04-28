<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserInformationNotification.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserInformationNotification
 * @package xkamen06\pms\Notifications
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
                    ->line(trans('pms::Notifications.UserInformation.login_information'))
                    ->line(trans('pms::Notifications.UserInformation.email') . $this->email)
                    ->line(trans('pms::Notifications.UserInformation.password') . $this->password)
                    ->line(trans('pms::Notifications.UserInformation.change_password'))
                    ->action(trans('pms::Notifications.UserInformation.go_to_system'), url('/'))
                    ->line(trans('pms::Notifications.thank_you'));
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
