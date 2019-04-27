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
        'header' => 'Zmeniť heslo',
        'error' => 'Chyba',
        'insert_your_password' => 'Prosím zadajte svoje heslo:',
        'insert_new_password_this_user' => 'Zadajte nové heslo pre tohto používateľa:',
        'insert_old_password' => 'Zadajte staré heslo:',
        'insert_new_password' => 'Zadajte nové heslo:',
        'button-change_password' => 'Zmeniť heslo',
        'error_msg_badpaswword' => 'Zadal(a) jste špatné pôvodné heslo.',
        'password_minimum_length' => 'Heslo musí obsahovať minimálne 8 znaku.'
    ],

    'edit' => [
        'header' => 'Upraviť používateľa',
        'firstname' => 'Jmeno:',
        'surname' => 'Priezvisko:',
        'email' => 'Email:',
        'button-edit' => 'Upraviť',
        'error_msg_user_exist' => 'Používateľ s týmto emailom už existuje.',
        'error' => 'Chyba'
    ],

    'index' => [
        'header' => 'Všetci používatelia',
        'no' => 'Č.',
        'firstname' => 'Jmeno',
        'surname' => 'Priezvisko',
        'add_user' => 'Pridať používateľa',
        'delete' => 'Odobrať používateľa',
        'show' =>'Zobraziť používateľa',
        'are_you_sure' => 'Ste si istý/á, že chcete odstrániť používateľa',
        'from_system' => ' zo systému?'
    ],

    'show' => [
        'user_profile' => 'Profil používateľa',
        'change_informations' => 'Upraviť údaje',
        'change_password' => 'Zmeniť heslo',
        'firstname' => 'Jmeno:',
        'surname' => 'Priezvisko:',
        'email' => 'Email:',
        'added' => 'Pridaný:',
        'teams' => 'Tímy',
        'shortcut' => 'Zkratka',
        'fullname' => 'Celý názov',
        'team_leader' => 'Vedoucí tímu',
        'leader' => 'Vedoucí',
        'member' => 'Člen',
        'not_a_team_member' => 'Používateľ nie je členom žiadneho tímu.',
        'projects' => 'Projekty',
        'project_leader' => 'Vedúci projektu',
        'not_a_project_member' => 'Užívateľ nepracuje na žiadnom projekte.',
        'send_mail' => 'Zaslať email',
        'show_team' => 'Zobraziť tím',
        'show_project' => 'Zobraziť projekt',
        'delete' => 'Odobrať používateľa',
        'are_you_sure' => 'Ste si istý/á, že chcete odstrániť používateľa',
        'from_system' => ' zo systému?'
    ],

    'create' => [
        'error' => 'Chyba',
        'add_user' => 'Pridať používateľa',
        'firstname' => 'Jmeno:',
        'surname' => 'Priezvisko:',
        'email' => 'Email:',
        'password' => 'Heslo:',
        'password_again' => 'Heslo znovu:',
        'button-add_user' => 'Pridať používateľa',
        'error_msg_badpassword' => 'Hesla sa neshodují.',
        'error_msg_user_exist' => 'Používateľ s týmto emailom už existuje.',
        'show_password' => 'Zobraziť heslo',
        'password_minimum_length' => 'Heslo musí obsahovať minimálne 8 znaku.'
    ]
];