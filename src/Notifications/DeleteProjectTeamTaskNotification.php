<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: DeleteProjectTeamTaskNotification.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class DeleteProjectTeamTaskNotification
 * @package App\Notifications
 */
class DeleteProjectTeamTaskNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $type, string $name)
    {
        $this->type = $type;
        $this->name = $name;
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
        if ($this->type === 'project') {
            return (new MailMessage)
                ->line(trans('Notifications.delete_project_team_task.deleted_project')
                    . ' ' . $this->name)
                ->action(trans('Notifications.delete_user_from.go_to_projects'), url('/allprojects'))
                ->line(trans('Notifications.thank_you'));
        } elseif ($this->type === 'team') {
            return (new MailMessage)
                ->line(trans('Notifications.delete_project_team_task.deleted_team')
                    . ' ' . $this->name)
                ->action(trans('Notifications.delete_user_from.go_to_teams'), url('/allteams'))
                ->line(trans('Notifications.thank_you'));
        } else {
            return (new MailMessage)
                ->line(trans('Notifications.delete_project_team_task.deleted_task')
                    . ' ' . $this->name)
                ->line(trans('Notifications.thank_you'));
        }
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
