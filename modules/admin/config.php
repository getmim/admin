<?php

return [
    '__name' => 'admin',
    '__version' => '0.8.0',
    '__git' => 'git@github.com:getmim/admin.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin' => ['install','update','remove'],
        'app/admin' => ['install','remove'],
        'theme/admin/me/' => ['install','update','remove'],
        'theme/admin/home.phtml' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin-ui' => NULL
            ],
            [
                'lib-user' => NULL
            ],
            [
                'lib-model' => NULL
            ],
            [
                'lib-view' => NULL
            ],
            [
                'lib-form' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-user-perm' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'Admin\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin/system/Controller.php',
                'children' => ['modules/admin/controller','app/admin/controller']
            ],
            'Admin\\Iface' => [
                'type' => 'file',
                'base' => 'modules/admin/interface'
            ],
            'Admin\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin/library'
            ],
            'Admin\\Service' => [
                'type' => 'file',
                'base' => 'modules/admin/service'
            ],
            'Admin\\Middleware' => [
                'type' => 'file',
                'base' => 'modules/admin/middleware'
            ]
        ],
        'files' => []
    ],
    'gates' => [
        'admin' => [
            'host' => [
                'value' => 'HOST'
            ],
            'path' => [
                'value' => '/admin'
            ],
            'priority' => 2000,
            'middlewares' => [
                'pre' => [
                    'Admin\\Middleware\\Login::auth' => 1
                ]
            ]
        ]
    ],
    'routes' => [
        'admin' => [
            404 => [
                'handler' => 'Admin\\Controller::show404'
            ],
            500 => [
                'handler' => 'Admin\\Controller::show500'
            ],
            'adminHome' => [
                'path' => [
                    'value' => '/'
                ],
                'handler' => 'Admin\\Controller\\Home::index',
                'method' => 'POST|GET'
            ],
            'adminMeLogin' => [
                'path' => [
                    'value' => '/me/login'
                ],
                'handler' => 'Admin\\Controller\\Auth::login',
                'method' => 'GET|POST'
            ],
            'adminMeLogout' => [
                'path' => [
                    'value' => '/me/logout'
                ],
                'handler' => 'Admin\\Controller\\Auth::logout'
            ],
            'adminMediaChunk' => [
                'path' => [
                    'value' => '/-/lib-upload/chunk',
                ],
                'method' => 'POST',
                'modules' => [
                    'lib-upload' => true
                ],
                'handler' => 'LibUpload\\Controller\\Upload::chunk'
            ],
            'adminMediaFilter' => [
                'path' => [
                    'value' => '/-/lib-upload/filter'
                ],
                'method' => 'GET',
                'modules' => [
                    'lib-upload' => TRUE
                ],
                'handler' => 'LibUpload\\Controller\\Upload::filter'
            ],
            'adminMediaFinalize' => [
                'path' => [
                    'value' => '/-/lib-upload/finalize',
                ],
                'method' => 'POST',
                'modules' => [
                    'lib-upload' => true
                ],
                'handler' => 'LibUpload\\Controller\\Upload::finalize'
            ],
            'adminMediaUpload' => [
                'path' => [
                    'value' => '/-/lib-upload/send'
                ],
                'method' => 'POST',
                'modules' => [
                    'lib-upload' => TRUE
                ],
                'handler' => 'LibUpload\\Controller\\Upload::init'
            ],
            'adminMediaValidate' => [
                'path' => [
                    'value' => '/-/lib-upload/validate'
                ],
                'method' => 'POST',
                'modules' => [
                    'lib-upload' => TRUE
                ],
                'handler' => 'LibUpload\\Controller\\Upload::validate'
            ],
            'adminObjectFilter' => [
                'path' => [
                    'value' => '/-/object/filter'
                ],
                'method' => 'GET',
                'handler' => 'Admin\\Controller\\Object::filter'
            ]
        ]
    ],
    'libEnum' => [
        'enums' => [
            'user.genders' => [
                '' => 'None',
                1 => 'Male',
                2 => 'Female',
                3 => 'Undefined'
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin-home' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE
                    ]
                ],
                'slug' => [
                    'label' => 'Slug',
                    'type' => 'text',
                    'slugof' => 'title',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ]
            ],
            'admin.me.login' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'nolabel' => TRUE,
                    'type' => 'password',
                    'meter' => FALSE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ]
            ]
        ]
    ],
    'adminUi' => [
        'navbarMenu' => [
            'handlers' => [
                'me-auth' => [
                    'class' => 'Admin\\Library\\Menu',
                    'parent' => 'none'
                ],
                'me-auth-logout' => [
                    'class' => 'Admin\\Library\\Menu',
                    'parent' => 'me-auth'
                ]
            ]
        ],
        'sidebarMenu' => [
            'items' => [
                'dashboard' => [
                    'label' => 'Dashboard',
                    'icon' => '<i class="fa fa-home" aria-hidden="true"></i>',
                    'route' => ['adminHome',[],[]],
                    'priority' => 100000,
                    'perms' => 'read_dashboard',
                    'filterable' => TRUE,
                    'visible' => TRUE
                ]
            ]
        ]
    ],
    'admin' => [
        'middleware' => [
            'login' => [
                'ignore' => []
            ]
        ],
        'objectFilter' => [
            'handlers' => [
                'timezone' => 'Admin\\Library\\TimezoneFilter'
            ]
        ],
        'login' => [
            'place' => 'holder',
            'frontpage' => FALSE
        ]
    ],
    'service' => [
        'admin/can_i' => 'Admin\\Service\\CanI'
    ]
];
