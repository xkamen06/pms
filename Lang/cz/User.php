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
        'header' => 'Změnit heslo',
        'error' => 'Chyba',
        'insert_your_password' => 'Prosím zadejte své heslo:',
        'insert_new_password_this_user' => 'Zadejte nové heslo pro tohoto uživatele:',
        'insert_old_password' => 'Zadejte staré heslo:',
        'insert_new_password' => 'Zadejte nové heslo:',
        'button-change_password' => 'Změnit heslo',
        'error_msg_badpassword' => 'Zadal(a) jste špatné původní heslo.',
        'password_minimum_length' => 'Heslo musí obsahovat minimálně 8 znaků.'
    ],

    'edit' => [
        'header' => 'Upravit uživatele',
        'firstname' => 'Jméno:',
        'surname' => 'Příjmení:',
        'email' => 'Email:',
        'button-edit' => 'Upravit',
        'error_user_exist' => 'Uživatel s tímto emailem již existuje.',
        'error' => 'Chyba'
    ],

    'index' => [
        'header' => 'Všichni uživatelé systému',
        'no' => 'Č.',
        'firstname' => 'Jméno',
        'surname' => 'Příjmení',
        'add_user' => 'Přidat uživatele',
        'delete' => 'Odebrat uživatele',
        'show' => 'Zobrazit uživatele',
        'are_you_sure' => 'Jste si jistý/á, že chcete odebrat uživatele ',
        'from_system' => ' ze systému?'
    ],

    'show' => [
        'user_profile' => 'Profil uživatele',
        'change_informations' => 'Upravit údaje',
        'change_password' => 'Změnit heslo',
        'firstname' => 'Jméno:',
        'surname' => 'Příjmení:',
        'email' => 'Email:',
        'added' => 'Přidán:',
        'teams' => 'Týmy',
        'shortcut' => 'Zkratka',
        'fullname' => 'Celý název',
        'team_leader' => 'Vedoucí týmu',
        'leader' => 'Vedoucí',
        'member' => 'Člen',
        'not_a_team_member' => 'Uživatel není členem žádného týmu.',
        'projects' => 'Projekty',
        'project_leader' => 'Vedoucí projektu',
        'not_a_project_member' => 'Uživatel nepracuje na žádném projektu.',
        'send_mail' => 'Zaslat email',
        'show_team' => 'Zobrazit tým',
        'show_project' => 'Zobrazit projekt',
        'delete' => 'Odebrat uživatele',
        'are_you_sure' => 'Jste si jistý/á, že chcete odebrat uživatele ',
        'from_system' => ' ze systému?'
    ],

    'create' => [
        'error' => 'Chyba',
        'add_user' => 'Přidat uživatele',
        'firstname' => 'Jméno:',
        'surname' => 'Příjmení:',
        'email' => 'Email:',
        'password' => 'Heslo:',
        'password_again' => 'Heslo znovu:',
        'button-add_user' => 'Přidat uživatele',
        'error_msg_badpassword' => 'Hesla se neshodují.',
        'error_msg_user_exist' => 'Uživatel s tímto emailem již existuje.',
        'show_password' => 'Zobrazit heslo',
        'password_minimum_length' => 'Heslo musí obsahovat minimálně 8 znaků.'
    ]
];