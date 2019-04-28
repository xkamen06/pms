<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: NewTeamArticleNotification.php
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
 * Class NewTeamArticleNotification
 * @package xkamen06\pms\Notifications
 */
class NewTeamArticleNotification extends Notification
{
    use Queueable;

    /**
     * @var \xkamen06\pms\Model\UserInterface
     */
    protected $user;

    /**
     * @var \xkamen06\pms\Model\TeamInterface
     */
    protected $team;

    /**
     * @var int
     */
    protected $articleId;

    /**
     * Create a new notification instance.
     *
     * @param int $userId
     *
     * @param int $teamId
     *
     * @param int $articleId
     *
     * @throws NotFoundHttpException
     */
    public function __construct(int $userId, int $teamId, int $articleId)
    {
        $this->user = userRepository()->getUserById($userId);
        $this->articleId = $articleId;
        $this->team = teamRepository()->getTeamById($teamId);
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
                    ->line(
                        trans('pms::Notifications.new_team_article.user')
                        . $this->user->getFirstname() . ' ' . $this->user->getSurname()
                        . trans('pms::Notifications.new_team_article.add_article_to_team')
                        . $this->team->getShortcut() . ' (' . $this->team->getFullname() . ').')
                    ->action(
                        trans('pms::Notifications.new_team_article.go_to_article'),
                        url('/showarticle/' . $this->articleId))
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
