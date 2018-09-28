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

    // courseController
    'study/{courseid:\d+}' => [
        'controller' => 'course',
        'action' => 'study',
    ],
    'study/checkTask' => [
        'controller' => 'course',
        'action' => 'checkTask',
    ],

    // payController
    'pay/{courseid:\d+}' => [
        'controller' => 'pay',
        'action' => 'pay',
    ],
    'pay/yandexkassa' => [
        'controller' => 'pay',
        'action' => 'yandexkassa',
    ],

    // adminController
    'admin/confirmtasks' => [
        'controller' => 'admin',
        'action' => 'confirmTasks',
    ],

];
