<?php
    /**
     * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
     * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
     *
     * Licensed under The MIT License
     * For full copyright and license information, please see the LICENSE.txt
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
     * @link      https://cakephp.org CakePHP(tm) Project
     * @since     3.3.0
     * @license   https://opensource.org/licenses/mit-license.php MIT License
     */

    namespace App;

    use Authentication\AuthenticationService;
    use Authentication\AuthenticationServiceInterface;
    use Authentication\AuthenticationServiceProviderInterface;
    use Authentication\Middleware\AuthenticationMiddleware;
    use Cake\Core\Configure;
    use Cake\Core\Exception\MissingPluginException;
    use Cake\Datasource\FactoryLocator;
    use Cake\Error\Middleware\ErrorHandlerMiddleware;
    use Cake\Http\BaseApplication;
    use Cake\Http\MiddlewareQueue;
    use Cake\Routing\Middleware\AssetMiddleware;
    use Cake\Routing\Middleware\RoutingMiddleware;
    use DebugKit\Plugin;
    use Psr\Http\Message\ServerRequestInterface;

    /**
     * Application setup class.
     *
     * This defines the bootstrapping logic and middleware layers you
     * want to use in your application.
     */
    class Application extends BaseApplication implements AuthenticationServiceProviderInterface
    {
        /**
         * {@inheritDoc}
         */
        public function bootstrap(): void
        {
            // Call parent to load bootstrap from files.
            parent::bootstrap();

            if (PHP_SAPI === 'cli') {
                $this->bootstrapCli();
            }

            /*
             * Only try to load DebugKit in development mode
             * Debug Kit should not be installed on a production system
             */
            if (Configure::read('debug')) {
                $this->addPlugin(Plugin::class);
                $this->addPlugin('IdeHelper');
            }

            // Load more plugins here
            $this->addPlugin(\CakeDC\Users\Plugin::class);
            $this->addPlugin('Wizardinstaller', ['bootstrap' => TRUE, 'routes' => TRUE, 'autoload' => TRUE]);
            $this->addPlugin('AppPluginsManager');
            $this->addPlugin('Migrations');
            $this->addPlugin('UserManager');
            $this->addPlugin('ItemsManager');

            $this->_loadPlugins();
        }

        private function _loadPlugins()
        {
            $pluginsTable = FactoryLocator::get('Table')
                                          ->get('AppPluginsManager.AppPlugins');
            $plugins = $pluginsTable->find('all')
                                    ->where(['activated' => TRUE]);
            foreach ($plugins as $plugin) {
                $this->addPlugin(
                    $plugin->name,
                    [
                        'bootstrap' => TRUE,
                        'routes'    => TRUE,
                        'autoload'  => TRUE
                    ]
                );
            }
        }

        /**
         * Setup the middleware queue your application will use.
         *
         * @param  MiddlewareQueue  $middlewareQueue  The middleware queue to setup.
         * @return MiddlewareQueue The updated middleware queue.
         */
        public function middleware($middlewareQueue): MiddlewareQueue
        {
            $middlewareQueue
                // Catch any exceptions in the lower layers,
                // and make an error page/response
                ->add(new ErrorHandlerMiddleware(NULL, Configure::read('Error')))
                // Handle plugin/theme assets like CakePHP normally does.
                ->add(new AssetMiddleware(['cacheTime' => Configure::read('Asset.cacheTime')]))
                // Add routing middleware.
                // Routes collection cache enabled by default, to disable route caching
                // pass null as cacheConfig, example: `new RoutingMiddleware($this)`
                // you might want to disable this cache in case your routing is extremely simple
                ->add(new RoutingMiddleware($this));

            return $middlewareQueue;
        }

        /**
         * @return void
         */
        protected function bootstrapCli()
        {
            try {
                $this->addPlugin('Bake');
            } catch (MissingPluginException $e) {
                // Do not halt if the plugin is missing
                debug($e->getMessage());
            }

            $this->addPlugin('Migrations');
            // Load more plugins here
        }

        public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
        {
            $service = new AuthenticationService();

            // Define where users should be redirected to when they are not authenticated
            $service->setConfig(['unauthenticatedRedirect' => '/users/login', 'queryParam' => 'redirect',]);

            $fields = [
                'username' => 'email',
                'password' => 'password'
            ];
            // Load the authenticators. Session should be first.
            $service->loadAuthenticator('Authentication.Session');
            $service->loadAuthenticator('Authentication.Form');

            // Load identifiers
            $service->loadIdentifier('Authentication.Password', compact('fields'));

            return $service;
        }
    }
