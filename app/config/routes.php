<?php
return [
    // mainController
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],

    // userController
    'login' => [
        'controller' => 'account',
        'action' => 'login',
    ],
    'register' => [
        'controller' => 'account',
        'action' => 'register',
    ],
    'confirmation' => [
        'controller' => 'account',
        'action' => 'confirmation',
    ],
    'account' => [
        'controller' => 'account',
        'action' => 'index',
    ],
    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],
    'account/editpass' => [
        'controller' => 'account',
        'action' => 'editpassword',
    ],

];
