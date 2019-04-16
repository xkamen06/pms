<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\CommentRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentRepositoryTest
 * @package PMS\Tests\Unit
 */
class CommentRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var string
     */
    protected $table = 'comment';

    /**
     * Returns if helper returns instance of repository
     *
     * @return bool
     */
    public function isRepositoryHelperInstanceOfRepository(): bool
    {
        return commentRepository() instanceof CommentRepositoryInterface;
    }

    /**
     * Get test object
     *
     * @return mixed
     */
    public function getTestObject()
    {
        //
    }

    /**
     * Get test object
     * 
     * @param string $articleOrTask
     * 
     * @return mixed
     */
    public function getTestCommentObject(string $articleOrTask)
    {
        if ($articleOrTask === 'article') {
            return DB::table($this->table)->whereNotNull('articleid')->first();
        }
        return DB::table($this->table)->whereNotNull('taskid')->first();
    }

    /** @test */
    public function get_comment_by_id_with_existing_id_should_return_object()
    {
        $commentId = $this->getTestCommentObject('article')->commentid;
        $comment = commentRepository()->getCommentById($commentId);
        $this->assertEquals($commentId, $comment->getCommentId());
    }

    /** @test */
    public function get_comment_by_id_without_existing_id_should_throw_exception()
    {
        $this->expectException(NotFoundHttpException::class);
        commentRepository()->getCommentById(0);
    }

    /** @test */
    public function get_comments_by_article_id_with_existing_id_should_return_nonempty_array()
    {
        $comment = $this->getTestCommentObject('article');
        $comments = commentRepository()->getCommentsByArticleId($comment->articleid);
        $this->assertNotEmpty($comments);
    }

    /** @test */
    public function get_comments_by_article_id_without_existing_id_should_return_empty_array()
    {
        $comments = commentRepository()->getCommentsByArticleId(0);
        $this->assertEmpty($comments);
    }

    /** @test */
    public function delete_comments_by_article_id_should_delete_articles()
    {
        $comment = $this->getTestCommentObject('article');
        $commentId = $comment->commentid;
        commentRepository()->deleteCommentsByArticleId($comment->articleid);
        $comment = DB::table($this->table)->where('commentid', $commentId)->first();
        $this->assertNull($comment);
    }

    /** @test */
    public function delete_comment_should_delete_comment()
    {
        $commentId = $this->getTestCommentObject('article')->commentid;
        commentRepository()->deleteComment($commentId);
        $comment = DB::table($this->table)->where('commentid', $commentId)->first();
        $this->assertNull($comment);
    }

    /** @test */
    public function update_article_should_update_article()
    {
        $commentId = $this->getTestCommentObject('article')->commentid;
        $value = 'aaa';
        commentRepository()->updateComment($commentId, [
            'content' => $value,
        ]);
        $article = DB::table($this->table)->where('commentid', $commentId)->first();
        $this->assertEquals($value, $article->content);
    }

    /** @test */
    public function get_comments_by_task_id_with_existing_id_should_return_nonempty_array()
    {
        $comment = $this->getTestCommentObject('task');
        $comments = commentRepository()->getCommentsByTaskId($comment->taskid);
        $this->assertNotEmpty($comments);
    }

    /** @test */
    public function get_comments_by_task_id_without_existing_id_should_return_empty_array()
    {
        $comments = commentRepository()->getCommentsByTaskId(0);
        $this->assertEmpty($comments);
    }

    /** @test */
    public function delete_comments_by_task_id_should_delete_articles()
    {
        $comment = $this->getTestCommentObject('task');
        $commentId = $comment->commentid;
        commentRepository()->deleteCommentsByTaskId($comment->taskid);
        $comment = DB::table($this->table)->where('commentid', $commentId)->first();
        $this->assertNull($comment);
    }
}
