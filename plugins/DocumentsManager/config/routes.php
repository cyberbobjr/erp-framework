<?php

    use Cake\Routing\Route\DashedRoute;
    use Cake\Routing\RouteBuilder;
    use Cake\Routing\Router;

    Router::plugin(
    'DocumentsManager',
    ['path' => '/documents-manager'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
