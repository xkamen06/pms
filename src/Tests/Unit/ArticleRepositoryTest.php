<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class ArticleRepositoryTest
 * @package PMS\Tests\Unit
 */
class ArticleRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var string
     */
    protected $table = 'article';

    /**
     * Returns if helper returns instance of repository
     * 
     * @return bool
     */
    public function isRepositoryHelperInstanceOfRepository(): bool
    {
        return articleRepository() instanceof ArticleRepositoryInterface;
    }

    /**
     * Get test object
     * 
     * @return mixed
     */
    public function getTestObject()
    {
        return DB::table($this->table)->first();
    }

    /** @test */
    public function get_few_articles_by_team_id_with_existing_id_should_return_nonempty_array()
    {
        $article = $this->getTestObject();
        $fewArticles = articleRepository()->getFewArticlesByTeamId($article->teamid, 1);
        $this->assertNotEmpty($fewArticles);
    }

    /** @test */
    public function get_few_articles_by_team_id_without_existing_id_should_return_empty_array()
    {
        $fewArticles = articleRepository()->getFewArticlesByTeamId(0, 1);
        $this->assertEmpty($fewArticles);
    }

    /** @test */
    public function get_all_articles_by_team_id_with_existing_id_should_return_nonempty_array()
    {
        $article = $this->getTestObject();
        $allArticles = articleRepository()->getAllArticlesByTeamId($article->teamid);
        $this->assertNotEmpty($allArticles);
    }

    /** @test */
    public function get_all_articles_by_team_id_without_existing_id_should_return_empty_array()
    {
        $allArticles = articleRepository()->getAllArticlesByTeamId(0);
        $this->assertEmpty($allArticles);
    }

    /** @test */
    public function get_article_by_id_with_existing_id_should_return_object()
    {
        $articleId = $this->getTestObject()->articleid;
        $article = articleRepository()->getArticleById($articleId);
        $this->assertEquals($articleId, $article->getArticleId());
    }

    /** @test */
    public function get_article_by_id_without_existing_id_should_throw_exception()
    {
        $this->expectException(NotFoundHttpException::class);
        articleRepository()->getArticleById(0);
    }

    /** @test */
    public function delete_article_by_id_should_delete_article()
    {
        $articleId = $this->getTestObject()->articleid;
        articleRepository()->deleteArticleById($articleId);
        $article = DB::table($this->table)->where('articleid', $articleId)->first();
        $this->assertNull($article);
    }

    /** @test */
    public function update_article_should_update_article()
    {
        $articleId = $this->getTestObject()->articleid;
        $value = 'aaa';
        $type = 'info';
        articleRepository()->updateArticle($articleId, [
            'title' => $value,
            'subtitle' => $value,
            'type' => $type,
            'content' => $value,
        ]);
        $article = DB::table($this->table)->where('articleid', $articleId)->first();
        $this->assertEquals($value, $article->title);
        $this->assertEquals($value, $article->subtitle);
        $this->assertEquals($value, $article->content);
        $this->assertEquals($type, $article->type);
    }
}
