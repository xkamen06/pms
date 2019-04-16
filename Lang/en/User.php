<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: User.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

return [
    'change_password' => [
        'header' => 'Change password',
        'error' => 'Error',
        'insert_your_password' => 'Insert your password:',
        'insert_new_password_this_user' => 'Insert a new password for this user:',
        'insert_old_password' => 'Insert an old password :',
        'insert_new_password' => 'Insert new password:',
        'button-change_password' => 'Change password',
        'error_msg_badpassword' => 'Bad old password.',
        'password_minimum_length' => 'Password must contain at least 8 characters.'
    ],

    'edit' => [
        'header' => 'Edit user',
        'firstname' => 'Firstname:',
        'surname' => 'Surname:',
        'email' => 'Email:',
        'button-edit' => 'Edit',
        'error_user_exist' => 'User with this email already exist.',
        'error' => 'Error'
    ],

    'index' => [
        'header' => 'All users',
        'no' => 'No.',
        'firstname' => 'Firtsname',
        'surname' => 'Surname',
        'add_user' => 'Add user',
        'delete' => 'Delete user',
        'show' => 'Show user',
        'are_you_sure' => 'Are you sure, that you want to delete user ',
        'from_system' => ' from system?'
    ],

    'show' => [
        'user_profile' => 'User profile',
        'change_informations' => 'Edit information',
        'change_password' => 'Change password',
        'firstname' => 'Firstname:',
        'surname' => 'Surname:',
        'email' => 'Email:',
        'added' => 'Added:',
        'teams' => 'Teams',
        'shortcut' => 'Shortcut',
        'fullname' => 'Fullname',
        'team_leader' => 'Team leader',
        'leader' => 'Leader',
        'member' => 'Member',
        'not_a_team_member' => 'This user has no teams.',
        'projects' => 'Projects',
        'project_leader' => 'Project leader',
        'not_a_project_member' => 'This user does not work on projects.',
        'send_mail' => 'Send email',
        'show_team' => 'Show team',
        'show_project' => 'Show project',
        'delete' => 'Delete user',
        'are_you_sure' => 'Are you sure, that you want to delete user ',
        'from_system' => ' from system?'
    ],

    'create' => [
        'error' => 'Error',
        'add_user' => 'Add user',
        'firstname' => 'Firstname:',
        'surname' => 'Surname:',
        'email' => 'Email:',
        'password' => 'Password:',
        'password_again' => 'Password again:',
        'button-add_user' => 'Add user',
        'error_msg_badpassword' => 'Passwords not match.',
        'error_msg_user_exist' => 'User with this email already exist.',
        'show_password' => 'Show password',
        'password_minimum_length' => 'Password must contain at least 8 characters.'
    ]
];