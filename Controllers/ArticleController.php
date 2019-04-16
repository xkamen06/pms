<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleInterface;
use xkamen06\pms\Model\TeamInterface;

/**
 * Class ArticleController
 * @package xkamen06\pms\Controllers
 */
class ArticleController
{
    /**
     * Authorize user, if user can show the article
     *
     * @param TeamInterface $team
     *
     * @return void
     *
     * @throws UnauthorizedException
     */
    public function authorizeUserShow(TeamInterface $team) : void
    {
        if ($team->getPermissions() !== 'all' && auth()->user()->role !== 'admin' &&
            auth()->user()->id !== $team->getLeaderId() && !$team->isMember(auth()->user()->id)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user can add article
     *
     * @param int $teamId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserAdd(int $teamId) : void
    {
        $team = teamRepository()->getTeamById($teamId);
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $team->getLeaderId()
            && !$team->isMember(auth()->user()->id)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user can edit the article
     *
     * @param ArticleInterface $article
     *
     * @return void
     *
     * @throws UnauthorizedException
     */
    public function authorizeUserEdit(ArticleInterface $article) : void
    {
        if (auth()->user()->role !== 'admin' && $article->getUserId() !== auth()->user()->id) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user can delete the article
     *
     * @param ArticleInterface $article
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserDelete(ArticleInterface $article) : void
    {
        $team = teamRepository()->getTeamById($article->getTeamId());
        if (auth()->user()->role !== 'admin' && $article->getUserId() !== auth()->user()->id &&
            $team->getLeaderId() !== auth()->user()->id) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Shows all articles by team (identified by teamId)
     *
     * @param int $teamId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showArticlesByTeamId(int $teamId) : View
    {
        $team = teamRepository()->getTeamById($teamId);
        $this->authorizeUserShow($team);
        $articles = articleRepository()->getAllArticlesByTeamId($teamId);
        return view('pms::Article.indexbyteam', compact('articles', 'team'));
    }

    /**
     * Show article by articleId
     *
     * @param int $articleId
     *
     * @param int|null $editCommentId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showArticleById(int $articleId, ?int $editCommentId = null) : View
    {
        $article = articleRepository()->getArticleById($articleId);
        $team = teamRepository()->getTeamById($article->getTeamId());
        $this->authorizeUserShow($team);
        $comments = commentRepository()->getCommentsByArticleId($articleId);
        return view('pms::Article.show', compact('article', 'comments', 'editCommentId', 'team'));
    }

    /**
     * Delete article by articleId
     *
     * @param int $articleId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteArticleById(int $articleId) : RedirectResponse
    {
        $article = articleRepository()->getArticleById($articleId);
        $this->authorizeUserDelete($article);
        articleRepository()->deleteArticleById($articleId);
        Cache::flush();
        if (strpos(URL::previous(), 'showarticle')) {
            return redirect()->route('articlesbyteam', ['teamId' => $article->getTeamId()]);
        }
        return redirect()->back();
    }

    /**
     * Show edit form for article (identified by articleId)
     *
     * @param int $articleId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showEditForm(int $articleId) : View
    {
        $article = articleRepository()->getArticleById($articleId);
        $this->authorizeUserEdit($article);
        return view('pms::Article.edit', compact('article'));
    }

    /**
     * Update article by articleId
     *
     * @param int $articleId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function updateArticle(int $articleId, Request $request) : RedirectResponse
    {
        $article = articleRepository()->getArticleById($articleId);
        $this->authorizeUserEdit($article);
        $path = null;
        if (isset($request['image'])) {
            $file = $request->file('image');
            if ($file === null) {
                throw new NotFoundHttpException();
            }
            $path = $file->store('public');
        }
        articleRepository()->updateArticle($articleId, $request->all(), $path);
        Cache::flush();
        return redirect()->route('articlebyid', ['articleId' => $articleId]);
    }

    /**
     * Show form to add article
     *
     * @param int $teamId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showAddForm(int $teamId) : View
    {
        $this->authorizeUserAdd($teamId);
        return view('pms::Article.create', compact('teamId'));
    }

    /**
     * Add article
     *
     * @param int $teamId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addArticle(int $teamId, Request $request) : RedirectResponse
    {
        $this->authorizeUserAdd($teamId);
        $path = null;
        if (isset($request['image'])) {
            $file = $request->file('image');
            if ($file === null) {
                throw new NotFoundHttpException();
            }
            $path = $file->store('public');
        }
        articleRepository()->addArticle($teamId, $request->all(), $path);
        Cache::flush();
        return redirect()->route('articlesbyteam', ['teamId' => $teamId]);
    }
}