<?php

    declare(strict_types=1);

    namespace ItemsManager;

    use Cake\Core\BasePlugin;
    use Cake\Core\PluginApplicationInterface;
    use Cake\Http\MiddlewareQueue;
    use Cake\Routing\RouteBuilder;

    /**
     * Plugin for ItemsManager
     */
    class Plugin extends BasePlugin
    {
        /**
         * Load all the plugin configuration and bootstrap logic.
         *
         * The host application is provided as an argument. This allows you to load
         * additional plugin dependencies, or attach events.
         *
         * @param  PluginApplicationInterface  $app  The host application
         * @return void
         */
        public function bootstrap(PluginApplicationInterface $app): void
        {
        }

        /**
         * Add routes for the plugin.
         *
         * If your plugin has many routes and you would like to isolate them into a separate file,
         * you can create `$plugin/config/routes.php` and delete this method.
         *
         * @param  RouteBuilder  $routes  The route builder to update.
         * @return void
         */
        public function routes(RouteBuilder $routes): void
        {
            $routes->plugin(
                'ItemsManager',
                ['path' => '/items-manager'],
                static function (RouteBuilder $builder) {
                    // Add custom routes here

                    $builder->fallbacks();
                }
            );
            parent::routes($routes);
        }

        /**
         * Add middleware for the plugin.
         *
         * @param  MiddlewareQueue  $middlewareQueue
         * @return MiddlewareQueue
         */
        public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
        {
            // Add your middlewares here

            return $middlewareQueue;
        }
    }
