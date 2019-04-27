<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TeamRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use App\Notifications\AddUserToNotification;
use App\Notifications\DeleteProjectTeamTaskNotification;
use App\Notifications\DeleteUserFromNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TeamInterface;
use xkamen06\pms\Model\TeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class TeamRepository
 * @package xkamen06\pms\Model\Items
 */
class TeamRepository extends Repository implements TeamRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'team';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['TeamRepository', 'team'];


    /**
     * Fetched row from database to UserItem
     *
     * @param $fetchedRow
     *
     * @return TeamInterface
     *
     * @throws NotFoundHttpException
     */
    protected function toItem($fetchedRow) : TeamInterface
    {
        if($fetchedRow === null) {
            throw new NotFoundHttpException();
        }
        return new TeamItem((array)$fetchedRow);
    }

    /**
     * Get all teams paginator
     *
     * @param int $perPage
     *
     * @param int $page
     *
     * @param array $skipedTeamsIds
     *
     * @return LengthAwarePaginator
     */
    public function getAllTeamsPaginator(array $skipedTeamsIds, int $perPage, int $page) : LengthAwarePaginator
    {
        return new LengthAwarePaginator($this->getItemsPerPage($skipedTeamsIds, $perPage, $page),
            $this->getCount(), $perPage, $page);
    }

    /**
     * Get team by its id
     *
     * @param int $teamId
     *
     * @return TeamInterface
     *
     * @throws  NotFoundHttpException
     */
    public function getTeamById(int $teamId) : TeamInterface
    {
        $cacheKey = 'TeamRepository.getTeamById' . $teamId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($teamId) {
            return $this->toItem($this->getQuery()->where('teamid', '=', $teamId)->first());
        });
    }

    /**
     * Delete user from team by id
     *
     * @param int $userId
     *
     * @param int $teamId
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function deleteUserFromTeamById(int $userId, int $teamId) : void
    {
        $user = userRepository()->getUserById($userId);
        $user->notify(new DeleteUserFromNotification('team', $teamId));
        DB::table('user_team')->where('userid', '=', $userId)->where('teamid', '=', $teamId)->delete();
    }

    /**
     * Get teams by user id
     *
     * @param int $userId
     *
     * @return array
     */
    public function getTeamsByUserId(int $userId) : array
    {
        $cacheKey = 'TeamRepository.getTeamsByUserId' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            $teamIds = DB::table('user_team')->where('userid', '=', $userId)->pluck('teamid');
            return $this->toItems($this->getQuery()->whereIn('teamid', $teamIds)
                ->orWhere('leaderid', $userId)->get());
        });
    }

    /**
     * Get teams count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getTeamsCountByUserId(int $userId) : int
    {
        $cacheKey = 'TeamRepository.getTeamsCountByUserId' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            $teamIds = DB::table('user_team')->where('userid', '=', $userId)->pluck('teamid');
            return $this->getQuery()->whereIn('teamid', $teamIds)
                ->orWhere('leaderid', $userId)->count();
        });

    }

    /**
     * Delete team and its items by id
     *
     * @param int $teamId
     *
     * @throws NotFoundHttpException
     */
    public function deleteTeamById(int $teamId) : void
    {
        $articles = articleRepository()->getAllArticlesByTeamId($teamId);
        foreach ($articles as $article) {
            articleRepository()->deleteArticleById($article->getArticleId());
        }
        $teamName = $this->getTeamById($teamId)->getShortcut();
        $users = userRepository()->getUsersByTeamId($teamId);
        foreach ($users as $user) {
            $user->notify(new DeleteProjectTeamTaskNotification('team', $teamName));
        }
        DB::table('user_team')->where('teamid', '=', $teamId)->delete();
        $this->getQuery()->where('teamid', '=', $teamId)->delete();
    }

    /**
     * Update team by id
     *
     * @param int $teamId
     *
     * @param array $params
     *
     * @return string
     */
    public function updateTeam(int $teamId, array $params) : string
    {
        $team = $this->getQuery()->where('shortcut', $params['shortcut'])->first();
        if ($team && $team->teamid !== $teamId) {
            return 'shortcut_exist';
        }
        $this->getQuery()->where('teamid', '=', $teamId)->update([
            'shortcut' => $params['shortcut'],
            'fullname' => $params['fullname'],
            'description' => $params['description'],
            'permissions' => $params['permissions'],
        ]);
        return '';
    }

    /**
     * Create team
     *
     * @param array $params
     *
     * @return int
     */
    public function createTeam(array $params) : int
    {
        if ($this->getQuery()->where('shortcut', $params['shortcut'])->first()) {
            return -1;
        }
        return $this->getQuery()->insertGetId([
            'shortcut' => $params['shortcut'],
            'fullname' => $params['fullname'],
            'description' => $params['description'],
            'permissions' => $params['permissions'],
            'leaderid' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Add members to team
     *
     * @param int $teamId
     *
     * @param array $params
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function addMembers(int $teamId, array $params) : void
    {
        unset($params['_token']);
        foreach ($params as $param => $p) {
            DB::table('user_team')->insert([
                'user_teamid' => (int)($param . $teamId),
                'userid' => $param,
                'teamid' => $teamId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $user = userRepository()->getUserById($param);
            $user->notify(new AddUserToNotification('team', $teamId));
        }
    }
}