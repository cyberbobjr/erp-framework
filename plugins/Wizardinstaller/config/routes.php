<?php

    use Cake\Routing\Route\DashedRoute;
    use Cake\Routing\RouteBuilder;
    use Cake\Routing\Router;

    Router::plugin(
        'Wizardinstaller',
        ['path' => '/wizardinstaller'],
        function (RouteBuilder $routes) {
            $routes->setExtensions(['json',
                                    'xml',
                                    'ajax']);
            $routes->fallbacks(DashedRoute::class);
        }
    );

    Router::connect('/install', ['plugin'     => 'Wizardinstaller',
                                 'controller' => 'Install',
                                 'action'     => 'step',
                                 1]);

    Router::connect('/install/step/*', ['plugin'     => 'Wizardinstaller',
                                        'controller' => 'Install',
                                        'action'     => 'step']);

    Router::connect('/update', ['plugin'     => 'Wizardinstaller',
                                'controller' => 'Update',
                                'action'     => 'index',
                                1]);
