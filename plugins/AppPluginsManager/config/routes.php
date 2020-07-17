<?php

    use Cake\Routing\Route\DashedRoute;
    use Cake\Routing\RouteBuilder;
    use Cake\Routing\Router;

    Router::plugin(
        'AppPluginsManager',
        ['path' => '/app-plugins-manager'],
        static function (RouteBuilder $routes) {
            $routes->fallbacks(DashedRoute::class);
        }
    );
