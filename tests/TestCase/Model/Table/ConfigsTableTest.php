<?php

    namespace App\Test\TestCase\Model\Table;
    
    use App\Core\Menu\AppMenu;
    use App\Core\Menu\AppMenuManager;
    use App\Model\Table\ConfigsTable;
    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    /**
     * App\Model\Table\ConfigsTable Test Case
     */
    class ConfigsTableTest extends \Cake\TestSuite\TestCase
    {
        /**
         * Test subject
         *
         * @var ConfigsTable
         */
        public $Configs;
        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = ['app.Configs'];
        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            \App\Core\Menu\AppMenuManager::getInstance()->clearAll();
            $config = \Cake\ORM\TableRegistry::getTableLocator()->exists('Configs') ? [] : ['className' => \App\Model\Table\ConfigsTable::class];
            $this->Configs = \Cake\ORM\TableRegistry::getTableLocator()->get('Configs', $config);
        }
        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Configs);
            parent::tearDown();
        }
        public function test_should_get_menu_manager()
        {
            self::assertInstanceOf(\App\Core\Menu\AppMenuManager::class, \App\Core\Menu\AppMenuManager::getInstance());
        }
        public function test_should_add_menu()
        {
            $pluginName = 'Test';
            $mainMenu = \App\Core\Menu\AppMenuManager::getInstance();
            $menu = new \App\Core\Menu\AppMenu('', 'Menu 1', 0, '');
            $submenu = $mainMenu->addMenu($pluginName, $menu, [], 'left');
            self::assertArraySubset(['icon' => NULL, 'label' => 'Menu 1', 'url' => '', 'order' => 0, 'submenus' => []], $submenu);
        }
        public function test_should_get_menu_for_position()
        {
            $pluginName = 'Test';
            $url = "http://test.com";
            $mainMenu = \App\Core\Menu\AppMenuManager::getInstance();
            $menu = new \App\Core\Menu\AppMenu($url, 'Menu 1', 0, '');
            $mainMenu->addMenu($pluginName, $menu, [], 'left');
            $menu = new \App\Core\Menu\AppMenu($url, 'Menu 2', 0, '');
            $mainMenu->addMenu($pluginName, $menu, [], 'right');
            $getMenus = $mainMenu->getMenusWithPosition('left');
            self::assertArraySubset(['icon' => NULL, 'label' => 'Menu 1', 'url' => $url, 'order' => 0, 'submenus' => []], $getMenus['Test'][0]);
            $getMenus = $mainMenu->getMenusWithPosition('right');
            self::assertArraySubset(['icon' => NULL, 'label' => 'Menu 2', 'url' => $url, 'order' => 0, 'submenus' => []], $getMenus['Test'][0]);
        }
    }
