<?php

    namespace App\Test\TestCase\View\Helper;
    
    use App\Core\Menu\AppMenu;
    use App\Core\Menu\AppMenuManager;
    use App\View\Helper\MenusHelper;
    use Cake\TestSuite\TestCase;
    use Cake\View\View;
    /**
     * App\View\Helper\MenusHelper Test Case
     */
    class MenusHelperTest extends \Cake\TestSuite\TestCase
    {
        /**
         * Test subject
         *
         * @var MenusHelper
         */
        public $Menus;
        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            \App\Core\Menu\AppMenuManager::getInstance()->clearAll();
            $view = new \Cake\View\View();
            $this->Menus = new \App\View\Helper\MenusHelper($view);
        }
        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Menus);
            parent::tearDown();
        }
        /**
         * Test initial setup
         *
         * @return void
         */
        public function test_should_return_menu_for_position()
        {
            $pluginName = 'Test';
            $position = 'left';
            $url = 'http://www.test.com/';
            $label = 'Menu 1';
            $expected = "<li><a href='{$url}'>{$label}</a></li>";
            $mainMenu = \App\Core\Menu\AppMenuManager::getInstance();
            $menu = new \App\Core\Menu\AppMenu($url, $label, 0, '');
            $mainMenu->addMenu($pluginName, $menu, [], $position);
            $menus = $this->Menus->displayMenuFor($position);
            $this->assertXmlStringEqualsXmlString($expected, $menus);
        }
        public function test_should_return_menu_and_submenu_for_position()
        {
            $pluginName = 'Test';
            $position = 'left';
            $url = 'http://www.test.com/';
            $label = 'Dropdown';
            $submenulabel = 'Action';
            $expected = "<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Dropdown <span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a href=\"" . $url . "\">Action</a></li></ul></li>";
            $mainMenu = \App\Core\Menu\AppMenuManager::getInstance();
            $menu = new \App\Core\Menu\AppMenu($url, $label, 0, '');
            $submenu = new \App\Core\Menu\AppMenu($url, $submenulabel, 0, '');
            $mainMenu->addMenu($pluginName, $menu, [$submenu], $position);
            $htmlMenu = $this->Menus->displayMenuFor($position);
            $this->assertXmlStringEqualsXmlString($expected, $htmlMenu);
        }
        public function test_should_return_separator()
        {
            $expected = '<li role="separator" class="divider"></li>';
            $label = '-';
            $position = 'left';
            $mainMenu = \App\Core\Menu\AppMenuManager::getInstance();
            $menu = new \App\Core\Menu\AppMenu('', $label, 0, '');
            $mainMenu->addMenu('Test', $menu, NULL);
            $htmlMenu = $this->Menus->displayMenuFor($position);
            $this->assertXmlStringEqualsXmlString($expected, $htmlMenu);
        }
        public function test_should_add_submenu_to_existing_menu()
        {
            $expected = '<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">main menu <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href=\'#\'>test</a></li>
                            </ul>
                         </li>';
            $label = 'main menu';
            $position = 'left';
            $mainMenu = \App\Core\Menu\AppMenuManager::getInstance();
            $menu = new \App\Core\Menu\AppMenu('', $label, 0, '');
            $mainMenu->addMenu('Test', $menu, NULL);
            $subMenu = new \App\Core\Menu\AppMenu('#', 'test', 0, '');
            $mainMenu->addSubmenu('Test', $position, [$subMenu]);
            $htmlMenu = $this->Menus->displayMenuFor($position);
            $this->assertXmlStringEqualsXmlString($expected, trim($htmlMenu));
        }
    }
