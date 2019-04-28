<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: NewArticleCommentNotification.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleInterface;

/**
 * Class NewArticleCommentNotification
 * @package xkamen06\pms\Notifications
 */
class NewArticleCommentNotification extends Notification
{
    use Queueable;

    /**
     * @var ArticleInterface
     */
    protected $article;

    /**
     * @var \xkamen06\pms\Model\UserInterface
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param int $userId
     *
     * @param ArticleInterface $article
     *
     * @throws NotFoundHttpException
     */
    public function __construct(int $userId, ArticleInterface $article)
    {
        $this->article = $article;
        $this->user = userRepository()->getUserById($userId);
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
                trans('pms::Notifications.new_comment.user')
                    . $this->user->getFirstname() . ' ' . $this->user->getSurname()
                    . trans('pms::Notifications.new_comment.add_comment_to_article')
                    . $this->article->getTitle()
                  )
                ->action('Notifications.new_comment.go_to_article',
                  url('/showarticle/' . $this->article->getArticleId()))
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
