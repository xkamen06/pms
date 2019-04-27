<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CommentController
 * @package xkamen06\pms\Controllers
 */
class CommentController
{
    /**
     * Authorize user, if user is able to add comment to the article
     *
     * @param int $articleId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserAddToArticle(int $articleId) : void
    {
        $article = articleRepository()->getArticleById($articleId);
        $team = teamRepository()->getTeamById($article->getTeamId());
        if (auth()->user()->role !== 'admin' &&
            auth()->user()->id !== $team->getLeaderId() && !$team->isMember(auth()->user()->id)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user is able to add comment to the task
     *
     * @param int $taskId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserAddToTask(int $taskId) : void
    {
        $task = taskRepository()->getTaskById($taskId);
        $project = projectRepository()->getProjectById($task->getProjectId());
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $project->getLeaderId()
            && !$project->isMember(auth()->user()->id)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user is able to delete the comment
     *
     * @param int $commentId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserDelete(int $commentId) : void
    {
        $comment = commentRepository()->getCommentById($commentId);
        if ($comment->getArticleId()) {
            $article = articleRepository()->getArticleById($comment->getArticleId());
            $team = teamRepository()->getTeamById($article->getTeamId());
            if (auth()->user()->role !== 'admin' && auth()->user()->id !== $comment->getUserId()
                && $team->getLeaderId() !== auth()->user()->id) {
                throw new UnauthorizedException('Permission denied.');
            }
        } else {
            $task = taskRepository()->getTaskById($comment->getTaskId());
            $project = projectRepository()->getProjectById($task->getProjectId());
            if (auth()->user()->role !== 'admin' && auth()->user()->id !== $comment->getUserId()
                && $project->getLeaderId() !== auth()->user()->id) {
                throw new UnauthorizedException('Permission denied.');
            }
        }
    }

    /**
     * Authorize user, if user is able to update the comment
     *
     * @param int $commentId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserUpdate(int $commentId) : void
    {
        $comment = commentRepository()->getCommentById($commentId);
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $comment->getUserId()) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Add comment to article
     *
     * @param int $articleId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addArticleComment(int $articleId, Request $request) : RedirectResponse
    {
        $this->authorizeUserAddToArticle($articleId);
        commentRepository()->addComment(['articleid' => $articleId], $request->all());
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Add comment to task
     *
     * @param int $taskId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addTaskComment(int $taskId, Request $request) : RedirectResponse
    {
        $this->authorizeUserAddToTask($taskId);
        commentRepository()->addComment(['taskid' => $taskId], $request->all());
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Delete comment
     *
     * @param int $commentId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteComment(int $commentId) : RedirectResponse
    {
        $this->authorizeUserDelete($commentId);
        commentRepository()->deleteComment($commentId);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Update article comment
     *
     * @param int $commentId
     *
     * @param int $articleId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function updateArticleComment(int $commentId, int $articleId, Request $request) : RedirectResponse
    {
        $this->authorizeUserUpdate($commentId);
        commentRepository()->updateComment($commentId, $request->all());
        Cache::flush();
        return redirect()->route('articlebyid', ['articleId' => $articleId]);
    }

    /**
     * Update task comment
     *
     * @param int $commentId
     *
     * @param int $taskId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function updateTaskComment(int $commentId, int $taskId, Request $request) : RedirectResponse
    {
        $this->authorizeUserUpdate($commentId);
        commentRepository()->updateComment($commentId, $request->all());
        Cache::flush();
        return redirect()->route('showtask', ['taskId' => $taskId]);
    }
}