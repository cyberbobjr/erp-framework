<?php

    namespace App\Test\TestCase\View\Helper;

    use App\Core\AppHookManager;
    use App\View\Helper\HooksHelper;
    use Cake\TestSuite\TestCase;
    use Cake\View\View;

    /**
     * App\View\Helper\HooksHelper Test Case
     */
    class HooksHelperTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var \App\View\Helper\HooksHelper
         */
        public $Hooks;
        private $pluginName = 'ExamplePlugin';
        private $controllerName = 'Test';
        private $actionName = 'index';

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            $this->loadPlugins([$this->pluginName]);
            $view = new View();
            $view->setPlugin($this->pluginName);
            $view->name = $this->controllerName;
            $view->setTemplatePath($this->controllerName);
            $view->setTemplate($this->actionName);
            $view->enableAutoLayout(FALSE);
            $view->render($this->actionName);
            $this->Hooks = new HooksHelper($view);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Hooks);

            parent::tearDown();
        }

        /**
         * Test initial setup
         *
         * @return void
         */
        public function test_should_return_hooked_with_element_entity()
        {
            $expected = '<i class="fa fa-question"></i>';
            AppHookManager::getInstance()
                          ->clear();
            AppHookManager::getInstance()
                          ->addHook(join('.', [$this->pluginName,
                                               $this->controllerName,
                                               $this->actionName,
                                               'test']), 'ExamplePlugin.element_inject');
            $resultHtml = $this->Hooks->getHooks('test');
            self::assertXmlStringEqualsXmlString($expected, $resultHtml);
        }

        public function test_should_return_hooked_with_cell_entity()
        {
            $expected = '<button class="btn btn-xs btn-primary" type="button"><i class="fa fa-user"></i> Test Button</button>';
            AppHookManager::getInstance()
                          ->clear();
            AppHookManager::getInstance()
                          ->addHook(join('.', [$this->pluginName,
                                               $this->controllerName,
                                               $this->actionName,
                                               'test']), 'ExamplePlugin.CellSample', 'cell');
            $resultHtml = $this->Hooks->getHooks('test');
            self::assertXmlStringEqualsXmlString($expected, $resultHtml);
        }

        public function test_should_return_hooked_with_cellfunction_entity()
        {
            $expected = '<i class="fa fa-qrcode"></i>';
            AppHookManager::getInstance()
                          ->clear();
            AppHookManager::getInstance()
                          ->addHook(join('.', [$this->pluginName,
                                               $this->controllerName,
                                               $this->actionName,
                                               'test']), 'ExamplePlugin.CellSample::testDisplay', 'cell');
            $resultHtml = $this->Hooks->getHooks('test');
            self::assertXmlStringEqualsXmlString($expected, $resultHtml);
        }

        public function test_should_clear_App_hook_manager()
        {
            AppHookManager::getInstance()
                          ->addHook(join('.', [$this->pluginName,
                                               $this->controllerName,
                                               $this->actionName,
                                               'test']), 'ExamplePlugin.CellSample', 'cell');
            AppHookManager::getInstance()
                          ->clear();
            self::assertEquals(0, count(AppHookManager::getInstance()
                                                      ->getHooks('test')));
        }
    }
