<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserController.php
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
 * Class UserController
 * @package xkamen06\pms\Controllers
 */
class UserController
{
    /**
     * Number of items per page
     *
     * @var int
     */
    private $perPage = 20;

    /**
     * Authorize user, if user is able to do the action
     *
     * @param int $userId
     *
     * @return void
     *
     * @throws UnauthorizedException
     */
    private function authorizeUser(int $userId) : void
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $userId) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user is able to do the action
     *
     * @return void
     *
     * @throws UnauthorizedException
     */
    private function authorizeUserAddDeleteUser() : void
    {
            if (auth()->user()->role !== 'admin') {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Show all users
     *
     * @return View
     */
    public function showAllUsers() : View
    {
        $usersPaginator = userRepository()->getAllUsersPaginator($this->perPage, request('page', 1));
        $usersPaginator->setPath('/allusers');
        return view('pms::User.index', [
            'usersPaginator' => $usersPaginator,
            'perPage' => $this->perPage]
        );
    }

    /**
     * Show user profile
     *
     * @param int $userId
     *
     * @return View
     *
     * @throws NotFoundHttpException
     */
    public function showUserProfile(int $userId) : View
    {
        $teams = teamRepository()->getTeamsByUserId($userId);
        $projects = projectRepository()->getProjectsByUserId($userId);
        $user = userRepository()->getUserById($userId);
        return view('pms::User.show', compact('user', 'teams', 'projects'));
    }

    /**
     * Show edit form
     *
     * @param int $userId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showEditForm(int $userId) : View
    {
        $this->authorizeUser($userId);
        $user = userRepository()->getUserById($userId);
        return view('pms::User.edit', compact('user'));
    }

    /**
     * Update user
     *
     * @param int $userId
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     *
     * @throws UnauthorizedException|NotFoundHttpException
     */
    public function updateUser(int $userId, Request $request)
    {
        $this->authorizeUser($userId);
        if (userRepository()->updateUser($userId, $request->all()) === 'user_exist') {
            $user = userRepository()->getUserById($userId);
            return view('pms::User.edit', [
                'user' => $user,
                'error' => trans('User.edit.error_user_exist')
            ]);
        }
        Cache::flush();
        return redirect()->route('userprofile', ['userId' => $userId]);
    }

    /**
     * Show change password form
     *
     * @param int $userId
     *
     * @return View
     *
     * @throws UnauthorizedException
     */
    public function showChangePasswordForm(int $userId) : View
    {
        $this->authorizeUser($userId);
        return view('pms::User.changepassword', ['userId' => $userId]);
    }

    /**
     * Update password
     *
     * @param int $userId
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     *
     * @throws UnauthorizedException
     */
    public function updatePassword(int $userId, Request $request)
    {
        $this->authorizeUser($userId);
        if (strlen($request['newpassword']) < 8) {
            return view('pms::User.changepassword', [
                'userId' => $userId,
                'error' => trans('User.change_password.password_minimum_length')
            ]);
        }
        if (userRepository()->updatePassword($userId, $request->all()) !== 'badpassword') {
            Cache::flush();
            return redirect()->route('userprofile', ['userId' => $userId]);
        }
        return view('pms::User.changepassword', [
            'userId' => $userId,
            'error' => trans('User.change_password.error_msg_badpassword')
        ]);
    }

    /** 
     * Delete user
     *
     * @param int $userId
     *
     * @return RedirectResponse
     * 
     * @throws UnauthorizedException
     */
    public function deleteUser(int $userId) : RedirectResponse
    {
        $this->authorizeUserAddDeleteUser();
        userRepository()->deleteUserById($userId);
        Cache::flush();
        return redirect()->route('allusers');
    }

    /**
     * Show add user form
     *
     * @return View
     *
     * @throws UnauthorizedException
     */
    public function showAddUserForm() : View
    {
        $this->authorizeUserAddDeleteUser();
        return view('pms::User.create');
    }

    /**
     * Add user
     *
     * @param Request $request
     *
     * @return RedirectResponse | View
     *
     * @throws UnauthorizedException
     */
    public function addUser(Request $request)
    {
        $this->authorizeUserAddDeleteUser();
        $status = userRepository()->addUser($request->all());
        if (strlen($request['password']) < 8) {
            return view('pms::User.create', [
                'error' => trans('User.create.password_minimum_length')
            ]);
        }
        if ($status === '') {
            Cache::flush();
            return redirect()->route('allusers');
        }
        if ($status === 'badpassword') {
            return view('pms::User.create', [
                'error' => trans('User.create.error_msg_badpassword')
            ]);
        }
        return view('pms::User.create', [
            'error' => trans('User.create.error_msg_user_exist')
        ]);
    }
}