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
    class ConfigsTableTest extends TestCase
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
        public $fixtures = [
            'app.Configs'
        ];

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp(): void
        {
            parent::setUp();
            AppMenuManager::getInstance()
                          ->clearAll();
            $config = TableRegistry::getTableLocator()
                                   ->exists('Configs') ? [] : ['className' => ConfigsTable::class];
            $this->Configs = TableRegistry::getTableLocator()
                                          ->get('Configs', $config);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown(): void
        {
            unset($this->Configs);

            parent::tearDown();
        }

        public function test_should_get_menu_manager()
        {
            self::assertInstanceOf(AppMenuManager::class, AppMenuManager::getInstance());
        }

        public function test_should_add_menu()
        {
            $pluginName = 'Test';
            $mainMenu = AppMenuManager::getInstance();
            $menu = new AppMenu('', 'Menu 1', 0, '');
            $submenu = $mainMenu->addMenu($pluginName, $menu, [], 'left');
            self::assertArraySubset([
                'icon'     => NULL,
                'label'    => 'Menu 1',
                'url'      => '',
                'order'    => 0,
                'submenus' => []
            ], $submenu);
        }

        public function test_should_get_menu_for_position()
        {
            $pluginName = 'Test';
            $url = "http://test.com";
            $mainMenu = AppMenuManager::getInstance();
            $menu = new AppMenu($url, 'Menu 1', 0, '');
            $mainMenu->addMenu($pluginName, $menu, [], 'left');

            $menu = new AppMenu($url, 'Menu 2', 0, '');
            $mainMenu->addMenu($pluginName, $menu, [], 'right');

            $getMenus = $mainMenu->getMenusWithPosition('left');
            self::assertArraySubset(['icon'     => NULL,
                                     'label'    => 'Menu 1',
                                     'url'      => $url,
                                     'order'    => 0,
                                     'submenus' => []], $getMenus['Test'][0]);

            $getMenus = $mainMenu->getMenusWithPosition('right');
            self::assertArraySubset(['icon'     => NULL,
                                     'label'    => 'Menu 2',
                                     'url'      => $url,
                                     'order'    => 0,
                                     'submenus' => []], $getMenus['Test'][0]);
        }
    }
