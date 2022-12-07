<?php


    namespace App\Test\TestCase\Core;


    use Cake\Routing\Route\DashedRoute;
    use Cake\Routing\RouteBuilder;
    use Cake\Routing\Router;
    use Cake\TestSuite\TestCase;
    use ExamplePlugin\Plugin;

    /**
     * Class AppBasePluginTest
     * @package App\Test\TestCase\Core
     * @property Plugin $basePlugin
     */
    class AppBasePluginTest extends TestCase
    {
        private $basePlugin;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.AppPluginsManager.app_plugins'
        ];

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp(): void
        {
            parent::setUp();
            Router::plugin(
                'TiersManager',
                ['path' => '/tiers-manager'],
                function (RouteBuilder $routes) {
                    $routes->fallbacks(DashedRoute::class);
                }
            );
            $this->loadPlugins(['ExamplePlugin' => ['bootstrap' => TRUE],
                                'TiersManager'  => ['route' => TRUE]]);
            $this->basePlugin = new Plugin();
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown(): void
        {
            $this->basePlugin->deactivate();
            parent::tearDown();
        }

        /**
         *
         */
        public function test_activate_plugin_should_return_true()
        {
            self::assertTrue($this->basePlugin->activate());
        }

        public function test_adding_hooks_should_return_true()
        {
            self::assertTrue($this->basePlugin->setHooks('Operationsanager.Operations.step1.actions', 'CellSampleCell'));
        }
    }
