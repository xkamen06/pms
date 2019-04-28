<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: DeleteUserFromNotification.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DeleteUserFromNotification
 * @package xkamen06\pms\Notifications
 */
class DeleteUserFromNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \xkamen06\pms\Model\ProjectInterface
     */
    protected $project;

    /**
     * @var \xkamen06\pms\Model\TeamInterface
     */
    protected $team;

    /**
     * @var \xkamen06\pms\Model\TaskInterface
     */
    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param string $type
     *
     * @param int $id
     *
     * @throws NotFoundHttpException
     */
    public function __construct(string $type, int $id)
    {
        if ($type === 'project') {
            $this->project = projectRepository()->getProjectById($id);
        } elseif ($type === 'team') {
            $this->team = teamRepository()->getTeamById($id);
        } else {
            $this->task = taskRepository()->getTaskById($id);
        }
        $this->type = $type;
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
                ->line(trans('pms::Notifications.delete_user_from.deleted_from_project')
                    . ' ' . $this->project->getShortcut() . '(' .  $this->project->getFullname() . ')')
                ->action(trans('pms::Notifications.delete_user_from.go_to_projects'), url('/showproject/'
                    . $this->project->getProjectId()))
                ->line(trans('pms::Notifications.thank_you'));
        } elseif ($this->type === 'team') {
            return (new MailMessage)
                ->line(trans('pms::Notifications.delete_user_from.deleted_from_team')
                    . ' ' . $this->team->getShortcut() . '(' .  $this->team->getFullname() . ')')
                ->action(trans('pms::Notifications.delete_user_from.go_to_teams'), url('/showteam/'
                    . $this->team->getTeamId()))
                ->line(trans('pms::Notifications.thank_you'));
        } else {
            return (new MailMessage)
                ->line(trans('pms::Notifications.delete_user_from.deleted_from_task')
                    . ' ' . $this->task->getName())
                ->action(trans('pms::Notifications.delete_user_from.go_to_tasks'), url('/showtask/'
                    . $this->task->getTaskId()))
                ->line(trans('pms::Notifications.thank_you'));
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
