<?php
return [
    // mainController
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],

    // accountController
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
    'account/editinfo' => [
        'controller' => 'account',
        'action' => 'editinfo',
    ],
    'users' => [
        'controller' => 'account',
        'action' => 'users',
    ],
    'user/{username:\w+}' => [
        'controller' => 'account',
        'action' => 'user',
    ],

    // courseController
    'course/{courseid:\d+}' => [
        'controller' => 'course',
        'action' => 'course',
    ],
    'study/{courseid:\d+}' => [
        'controller' => 'course',
        'action' => 'study',
    ],
    'study/checkTask' => [
        'controller' => 'course',
        'action' => 'checkTask',
    ],

    // projectController
    'projects' => [
        'controller' => 'project',
        'action' => 'projectslist',
    ],
    'project/{projectid:\w+}' => [
        'controller' => 'project',
        'action' => 'project',
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
    'admin/projects' => [
        'controller' => 'admin',
        'action' => 'projectslist',
    ],
    'admin/addproject' => [
        'controller' => 'admin',
        'action' => 'addproject',
    ],
    'admin/editproject/{projectid:\d+}' => [
        'controller' => 'admin',
        'action' => 'editproject',
    ],
    'admin/courses' => [
        'controller' => 'admin',
        'action' => 'courseslist',
    ],
    'admin/addcourse' => [
        'controller' => 'admin',
        'action' => 'addcourse',
    ],
    'admin/editcourse/{courseid:\d+}' => [
        'controller' => 'admin',
        'action' => 'editcourse',
    ],
    'admin/taskslist/{courseid:\d+}' => [
        'controller' => 'admin',
        'action' => 'taskslist',
    ],
    'admin/addtask/{courseid:\d+}' => [
        'controller' => 'admin',
        'action' => 'addtask',
    ],
    'admin/edittask/{taskid:\d+}' => [
        'controller' => 'admin',
        'action' => 'edittask',
    ],
    'admin/usercourses' => [
        'controller' => 'admin',
        'action' => 'usercourses',
    ],

];
