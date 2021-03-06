<?php

return [
    'is_dev_mode' => true,
    'controllers' => [
        'factories' => [
            'Neatline\Controller\Index' => 'Neatline\Service\Controller\IndexControllerFactory',
            'Neatline\Controller\Login' => 'Neatline\Service\Controller\LoginControllerFactory'
        ]
    ],
    'api_adapters' => [
        'invokables' => [
            'neatline_exhibits' => 'Neatline\Api\Adapter\ExhibitAdapter',
            'neatline_records' => 'Neatline\Api\Adapter\RecordAdapter',
            'login' => 'Neatline\Api\Adapter\LoginAdapter',
            'logout' => 'Neatline\Api\Adapter\LogoutAdapter'
        ],
    ],
    'block_layouts' => [
        'invokables' => [
            'neatlineExhibit' => 'Neatline\Site\BlockLayout\NeatlineExhibit',
        ],
    ],
    'navigation_links' => [
        'invokables' => [
            'neatline' => Neatline\Site\Navigation\Link\NeatlineBrowse::class,
        ],
    ],
    'entity_manager' => [
        'mapping_classes_paths' => [
            OMEKA_PATH . '/modules/Neatline/src/Entity',
        ],
        'resource_discriminator_map' => [
            'Neatline\Entity\NeatlineExhibit' => 'Neatline\Entity\NeatlineExhibit',
            'Neatline\Entity\NeatlineRecord' => 'Neatline\Entity\NeatlineRecord',
        ],
        'proxy_paths' => [
            OMEKA_PATH . '/modules/Neatline/data/doctrine-proxies',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH . '/modules/Neatline/view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Omeka\AuthenticationService' => 'Neatline\Service\NeatlineAuthenticationServiceFactory',
            'Neatline\NeatlineStatus' => 'Neatline\Service\NeatlineStatusFactory',
        ],
    ],
    'navigation' => [
        'AdminModule' => [
            [
                'label' => 'Neatline',
                'route' => 'admin/neatline',
                'resource' => 'Neatline\Controller\Index',
                'privilege' => 'browse',
                'pages' => [
                    [
                        'label'=> 'Neatline Editor',
                        'route' => 'admin/neatline/full',
                        'resource' => 'Neatline\Controller\Index',
                        'visible' => false,
                    ],
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'site' => [
                'child_routes' => [
                    'neatline' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/neatline',
                            'defaults' => [
                                '__NAMESPACE__' => 'Neatline\Controller',
                                'controller' => 'index',
                                'action' => 'browse',
                            ],
                        ],
                    ],
                    'show' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/neatline/show',
                            'defaults' => [
                                '__NAMESPACE__' => 'Neatline\Controller',
                                'controller' => 'index',
                                'action' => 'show',
                            ],
                        ],
                    ],
                ],
            ],
            'admin' => [
                'child_routes' => [
                    'neatline' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/neatline[/:spa_route[/:spa_subroute[/:spa_subroute_1[/:spa_subroute_2]]]]',
                            'constraints' => [
                                'spa_route' => 'show|add',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Neatline\Controller',
                                'controller' => 'index',
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'full' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/full[/:spa_route[/:spa_subroute[/:spa_subroute_1[/:spa_subroute_2]]]]',
                                    'constraints' => [
                                        'spa_route' => 'show|add',
                                    ],
                                    'defaults' => [
                                        'action' => 'full',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'login' => [
                'type' => \Zend\Router\Http\Regex::class,
                'options' => [
                    'regex' => '/login(/.*)?',
                    'spec' => '/login',
                    'defaults' => [
                        'controller' => 'Neatline\Controller\Login',
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => \Zend\Router\Http\Regex::class,
                'options' => [
                    'regex' => '/logout(/.*)?',
                    'spec' => '/logout',
                    'defaults' => [
                        'controller' => 'Neatline\Controller\Login',
                        'action' => 'logout',
                    ],
                ],
            ]
        ],
    ],
];
