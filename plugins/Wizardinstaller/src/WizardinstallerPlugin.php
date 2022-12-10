<?php
    declare(strict_types=1);

    namespace Wizardinstaller;

    use App\Core\Plugin\AppBasePlugin;
    use Cake\Console\CommandCollection;
    use Cake\Core\ContainerInterface;
    use Cake\Core\PluginApplicationInterface;
    use Cake\Http\MiddlewareQueue;
    use Cake\Routing\RouteBuilder;
    use Wizardinstaller\libs\CheckInstallService;
    use Wizardinstaller\libs\InstallService;

    class WizardinstallerPlugin extends AppBasePlugin
    {
        /**
         * Load all the plugin configuration and bootstrap logic.
         *
         * The host application is provided as an argument. This allows you to load
         * additional plugin dependencies, or attach events.
         *
         * @param PluginApplicationInterface $app The host application
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
         * @param RouteBuilder $routes The route builder to update.
         * @return void
         */
        public function routes(RouteBuilder $routes): void
        {
            $routes->plugin(
                'Wizardinstaller',
                ['path' => '/Wizardinstaller'],
                function (RouteBuilder $builder) {
                    // Add custom routes here

                    $builder->fallbacks();
                }
            );
            $routes->connect('/install', [
                'plugin'     => 'Wizardinstaller',
                'controller' => 'Install',
                'action'     => 'step',
                1]);
            $routes->connect('/install/step/*', ['plugin'     => 'Wizardinstaller',
                                                 'controller' => 'Install',
                                                 'action'     => 'step']);
            $routes->connect('/update', ['plugin'     => 'Wizardinstaller',
                                         'controller' => 'Update',
                                         'action'     => 'index',
                                         1]);
            parent::routes($routes);
        }

        /**
         * Add middleware for the plugin.
         *
         * @param MiddlewareQueue $middlewareQueue The middleware queue to update.
         * @return MiddlewareQueue
         */
        public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
        {
            // Add your middlewares here

            return $middlewareQueue;
        }

        /**
         * Add commands for the plugin.
         *
         * @param CommandCollection $commands The command collection to update.
         * @return CommandCollection
         */
        public function console(CommandCollection $commands): CommandCollection
        {
            // Add your commands here

            $commands = parent::console($commands);

            return $commands;
        }

        /**
         * Register application container services.
         *
         * @param ContainerInterface $container The Container to update.
         * @return void
         * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
         */
        public function services(ContainerInterface $container): void
        {
            // Add your services here
            $container->add(CheckInstallService::class);
            $container->add(InstallService::class);
        }
    }
