<?php

    use Cake\Routing\RouteBuilder;
    use Cake\Routing\Router;

    Router::plugin('UserManager', ['path' => '/user-manager'], function (RouteBuilder $routes) {
        $routes->connect('/users/login', ['plugin'     => 'UserManager',
                                          'controller' => 'Users',
                                          'action'     => 'login']);
        $routes->connect('/user-manager/:controller/:action/*', ['plugin' => 'UserManager']);
        $routes->connect('/user-manager/reset-password', ['plugin'     => 'UserManager',
                                                          'controller' => 'Users',
                                                          'action'     => 'reset_password']);
        $routes->connect('/users/register', ['plugin'     => 'UserManager',
                                             'controller' => 'Users',
                                             'action'     => 'register']);
        $routes->connect('/users/add', ['plugin'     => 'UserManager',
                                        'controller' => 'Users',
                                        'action'     => 'add']);
        $routes->connect('/users/logout', ['plugin'     => 'UserManager',
                                           'controller' => 'Users',
                                           'action'     => 'logout']);
        $routes->connect('/users/token', ['plugin'     => 'UserManager',
                                          'controller' => 'Users',
                                          'action'     => 'token']);
        $routes->connect('/users/reset-password', ['plugin'     => 'UserManager',
                                                   'controller' => 'Users',
                                                   'action'     => 'reset_password']);
        $routes->fallbacks('DashedRoute');
    });
