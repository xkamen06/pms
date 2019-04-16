<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TeamController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TeamController
 * @package xkamen06\pms\Controllers
 */
class TeamController
{
    /**
     * Number of items per page
     *
     * @var int
     */
    private $perPage = 20;

    /**
     * Sample of articles
     *
     * @var int
     */
    private $articleSample = 2;

    /**
     * Authorize user, if user is able to do the action
     *
     * @param int $teamId
     *
     * @param int|null $userId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    private function authorizeUser(int $teamId, ?int $userId = null) : void
    {

        $leaderId = teamRepository()->getTeamById($teamId)->getLeaderId();
        if ($userId) {
            if ((auth()->user()->role !== 'admin') && (auth()->user()->id !== $leaderId)
                && ($userId !== auth()->user()->id)) {
                throw new UnauthorizedException('Permission denied.');
            }
        } else {
            if ((auth()->user()->role !== 'admin') && (auth()->user()->id !== $leaderId)) {
                throw new UnauthorizedException('Permission denied.');
            }
        }
    }

    /**
     * Show all teams
     *
     * @return View
     */
    public function showAllTeams() : View
    {
        $myteams = teamRepository()->getTeamsByUserId(auth()->user()->id);
        $myteamsLeader = [];
        $myteamIds = [];
        foreach ($myteams as $i => $myteam) {
            $myteamIds[] = $myteam->getTeamId();
        }
        $teamsPaginator = teamRepository()->getAllTeamsPaginator($myteamIds, $this->perPage,
            request('page', 1));
        $teamsPaginator->setPath('/allteams');
        foreach ($myteams as $i => $team) {
            if ($team->getLeaderId() === auth()->user()->id) {
                $myteamsLeader[] = $team;
                unset($myteams[$i]);
            }
        }
        return view('pms::Team.index', compact('teamsPaginator', 'myteams', 'myteamsLeader'));
    }

    /**
     * Show team by teamId
     *
     * @param int $teamId
     *
     * @return View
     *
     * @throws NotFoundHttpException
     */
    public function showTeam(int $teamId) : View
    {
        $team = teamRepository()->getTeamById($teamId);
        $leader = $team->getLeader();
        $members = $team->getMembers();
        $articles = [];
        if ($team->getPermissions() === 'all' || auth()->user()->role === 'admin' ||
            $team->getLeaderId() === auth()->user()->id || $team->isMember(auth()->user()->id)) {
            $articles = articleRepository()->getFewArticlesByTeamId($teamId, $this->articleSample);
        }
        return view('pms::Team.show', compact('team', 'leader', 'members', 'articles'));
    }

    /**
     * Delete user (identified by userId) from team (identified by teamId)
     *
     * @param int $teamId
     *
     * @param int $userId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteUserFromTeam(int $teamId, int $userId) : RedirectResponse
    {
        $this->authorizeUser($teamId, $userId);
        teamRepository()->deleteUserFromTeamById($userId, $teamId);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Delete team by teamId
     *
     * @param int $teamId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteTeam(int $teamId) : RedirectResponse
    {
        $this->authorizeUser($teamId);
        teamRepository()->deleteTeamById($teamId);
        Cache::flush();
        return redirect()->route('allteams');
    }

    /**
     * Show edit form to edit team
     *
     * @param int $teamId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showEditForm(int $teamId) : View
    {
        $this->authorizeUser($teamId);
        $team = teamRepository()->getTeamById($teamId);
        return view('pms::Team.edit', compact('team'));
    }

    /**
     * Update team
     *
     * @param int $teamId
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function updateTeam(int $teamId, Request $request)
    {
        $this->authorizeUser($teamId);
        $status = teamRepository()->updateTeam($teamId, $request->all());
        if ($status === 'shortcut_exist') {
            $team = teamRepository()->getTeamById($teamId);
            return view('pms::Team.edit', [
                'team' => $team,
                'error' => trans('Team.edit.error_shortcut_exist')
            ]);
        }
        Cache::flush();
        return redirect()->route('showteam', ['teamId' => $teamId]);
    }

    /**
     * Show create team form
     *
     * @return View
     */
    public function showCreateForm() : View
    {
        return view('pms::Team.create');
    }

    /**
     * Create new team
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     */
    public function createTeam(Request $request)
    {
       $teamId = teamRepository()->createTeam($request->all());
       if ($teamId === -1) {
           return view('pms::Team.create', [
               'error' => trans('Team.create.error_shortcut_exist')
           ]);
       }
        Cache::flush();
        return redirect()->route('showteam', compact('teamId'));
    }

    /**
     * Show add member to team form
     *
     * @param int $teamId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showAddMemberForm(int $teamId) : View
    {
        $this->authorizeUser($teamId);
        $team = teamRepository()->getTeamById($teamId);
        $exceptIds = userRepository()->getUserIdsByTeamId($teamId);
        if ($team->getLeaderId()) {
            $exceptIds->push($team->getLeaderId());
        }
        $users = userRepository()->getUsersExceptIds($exceptIds);

        return view('pms::Team.addmembers', compact('users', 'teamId'));
    }

    /**
     * Add members to team
     *
     * @param int $teamId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addMembers(int $teamId, Request $request) : RedirectResponse
    {
        $this->authorizeUser($teamId);
        teamRepository()->addMembers($teamId ,$request->all());
        Cache::flush();
        return redirect()->route('showteam', compact('teamId'));
    }
}