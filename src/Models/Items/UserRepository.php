<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: Repository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use App\Notifications\UserInformationNotification;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\UserInterface;
use xkamen06\pms\Model\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use xkamen06\pms\Notifications\UserWasDeletedNotification;

/**
 * Class UserRepository
 * @package xkamen06\pms\Model\Items
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'users';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['UserRepository', 'users'];

    /**
     * Fetched row from database to UserItem
     *
     * @param $fetchedRow
     *
     * @return UserInterface
     *
     * @throws NotFoundHttpException
     */
    protected function toItem($fetchedRow) : UserInterface
    {
        if($fetchedRow === null) {
            throw new NotFoundHttpException();
        }
        return new UserItem((array)$fetchedRow);
    }

    /**
     * Gets user by id
     *
     * @param int $userId
     *
     * @return UserInterface
     *
     * @throws NotFoundHttpException
     */
    public function getUserById(int $userId) : UserInterface
    {
        $cacheKey = 'UserRepository.getUserById' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            return $this->toItem($this->getQuery()->where('id', '=', $userId)->first());
        });
    }

    /**
     * Update user by id
     *
     * @param int $userId
     *
     * @param array $params
     *
     * @return string
     */
    public function updateUser(int $userId, array $params) : string
    {
        $user = $this->getQuery()->where('email', $params['email'])->first();
        if ($user && $user->id !== $userId) {
            return 'user_exist';
        }
        $this->getQuery()->where('id', '=', $userId)->update([
            'firstname' => $params['firstname'],
            'surname' => $params['surname'],
            'email' => $params['email']
        ]);
        return '';
    }

    /**
     * Update user password by id
     *
     * @param int $userId
     *
     * @param array $params
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function updatePassword(int $userId, array $params) : string
    {
        if (auth()->user()->role === 'admin') {
            $password = $this->getQuery()->where('id', '=', auth()->user()->id)->select('password')->first();
        } else {
            $password = $this->getQuery()->where('id', '=', $userId)->select('password')->first();
        }

        $hasher = app(BcryptHasher::class);
        if($hasher->check($params['oldpassword'], $password->password)) {
            $this->getQuery()->where('id', '=', $userId)->update([
                'password' => bcrypt($params['newpassword'])
            ]);
            if (auth()->user()->role === 'admin') {
                $user = userRepository()->getUserById($userId);
                $user->notify(new UserInformationNotification($user->getEmail(), $params['newpassword']));
            }
            return '';
        }
        return 'badpassword';
    }

    /**
     * Get all users paginator
     *
     * @param int $perPage
     *
     * @param int $page
     *
     * @return LengthAwarePaginator
     */
    public function getAllUsersPaginator(int $perPage, int $page) : LengthAwarePaginator
    {
        return new LengthAwarePaginator($this->getItemsPerPage([auth()->user()->id], $perPage, $page), $this->getCount(),
            $perPage, $page);
    }

    /**
     * Get users by team id
     *
     * @param int $teamId
     *
     * @return array
     */
    public function getUsersByTeamId(int $teamId) : array
    {
        $cacheKey = 'UserRepository.getUsersByTeamId' . $teamId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($teamId) {
            return $this->toItems($this->getQuery()->whereIn('id',
            DB::table('user_team')->where('teamid', '=', $teamId)->pluck('userid'))->get());
        });
    }

    /**
     * Get userIds by teamId (get members ids)
     *
     * @param int $teamId
     * @return Collection
     */
    public function getUserIdsByTeamId(int $teamId) : Collection
    {
        $cacheKey = 'UserRepository.getUserIdsByTeamId' . $teamId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($teamId) {
            return DB::table('user_team')->where('teamid', '=', $teamId)->pluck('userid');
        });
    }

    /**
     * Get users except ids
     *
     * @param Collection $exceptIds
     *
     * @return array
     */
    public function getUsersExceptIds(Collection $exceptIds) : array
    {
        $cacheKey = 'UserRepository.getUsersExceptIds';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($exceptIds) {
            return $this->toItems($this->getQuery()->whereNotIn('id', $exceptIds)->get());
        });
    }

    /**
     * Get users by ids except ids
     *
     * @param Collection $exceptIds
     *
     * @param Collection $ids
     *
     * @return array
     */
    public function getUsersByIdsExceptIds(Collection $exceptIds, Collection $ids) : array
    {
        $cacheKey = 'UserRepository.getUsersByIdsExceptIds';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($exceptIds, $ids) {
            return $this->toItems($this->getQuery()->whereIn('id', $ids)->whereNotIn('id', $exceptIds)->get());
        });
    }

    /**
     * Get users by team id
     *
     * @param int $projectId
     *
     * @return array
     */
    public function getUsersByProjectId(int $projectId) : array
    {
        $cacheKey = 'UserRepository.getUsersByProjectId' . $projectId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($projectId) {
            return $this->toItems($this->getQuery()->whereIn('id',
                DB::table('user_project')->where('projectid', '=', $projectId)->pluck('userid'))->get());
        });
    }

    /**
     * Get userIds by taskId (get members ids)
     *
     * @param int $projectId
     * @return Collection
     */
    public function getUserIdsByProjectId(int $projectId) : Collection
    {
        $cacheKey = 'UserRepository.getUserIdsByProjectId' . $projectId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($projectId) {
            return DB::table('user_project')->where('projectid', '=', $projectId)->pluck('userid');
        });
    }

    /**
     * Get users by taskId (get members)
     *
     * @param int $taskId
     * @return array
     */
    public function getUsersByTaskId(int $taskId) : array
    {
        $cacheKey = 'UserRepository.getUsersByTaskId' . $taskId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($taskId) {
            return $this->toItems($this->getQuery()->whereIn('id',
                DB::table('user_task')->where('taskid', '=', $taskId)->pluck('userid'))->get());
        });
    }

    /**
     * Get userIds by taskId (get members ids)
     *
     * @param int $taskId
     * @return Collection
     */
    public function getUserIdsByTaskId(int $taskId) : Collection
    {
        $cacheKey = 'UserRepository.getUserIdsByTaskId' . $taskId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($taskId) {
            return DB::table('user_task')->where('taskid', '=', $taskId)->pluck('userid');
        });
    }

    /**
     * Add user
     *
     * @param array $params
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function addUser(array $params) : string
    {
        if ($this->existUserByEmail($params['email'])) {
            return 'userexist';
        }
        if ($params['password'] === $params['password_again']) {
            $userId = $this->getQuery()->insertGetId([
                'firstname' => $params['firstname'],
                'surname' => $params['surname'],
                'email' => $params['email'],
                'password' => bcrypt($params['password']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $user = userRepository()->getUserById($userId);
            $user->notify(new UserInformationNotification($params['email'], $params['password']));
            return '';
        }
        return 'badpassword';
    }

    /**
     * Delete user by id
     *
     * @param int $userId
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function deleteUserById(int $userId) : void
    {
        DB::table('user_team')->where('userid', '=', $userId)->delete();
        DB::table('user_task')->where('userid', '=', $userId)->delete();
        DB::table('user_project')->where('userid', '=', $userId)->delete();
        DB::table('project')->where('leaderid', '=', $userId)->update([
           'leaderid' => null
        ]);
        DB::table('team')->where('leaderid', '=', $userId)->update([
            'leaderid' => null
        ]);
        DB::table('task')->where('leaderid', '=', $userId)->update([
            'leaderid' => null
        ]);
        DB::table('comment')->where('userid', '=', $userId)->update([
            'userid' => null
        ]);
        DB::table('article')->where('userid', '=', $userId)->update([
            'userid' => null
        ]);
        DB::table('file')->where('userid', '=', $userId)->update([
            'userid' => null
        ]);
        $user = userRepository()->getUserById($userId);
        $user->notify(new UserWasDeletedNotification());
        $this->getQuery()->where('id', '=', $userId)->delete();
    }

    /**
     * Returns if user by email exists
     *
     * @param string $email
     *
     * @return bool
     */
    public function existUserByEmail(string $email) : bool
    {
        return ($this->getQuery()->where('email', $email)->first() !== null);
    }
}