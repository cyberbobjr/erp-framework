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
    class MenusHelperTest extends TestCase
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
        public function setUp(): void
        {
            parent::setUp();
            AppMenuManager::getInstance()
                          ->clearAll();
            $view = new View();
            $this->Menus = new MenusHelper($view);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown(): void
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
            $expected = "<li><a href='$url'>$label</a></li>";
            $mainMenu = AppMenuManager::getInstance();

            $menu = new AppMenu($url, $label, 0, '');
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
            $expected = "<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Dropdown <span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a href=\"".$url."\">Action</a></li></ul></li>";
            $mainMenu = AppMenuManager::getInstance();

            $menu = new AppMenu($url, $label, 0, '');
            $submenu = new AppMenu($url, $submenulabel, 0, '');

            $mainMenu->addMenu($pluginName, $menu, [$submenu], $position);

            $htmlMenu = $this->Menus->displayMenuFor($position);
            $this->assertXmlStringEqualsXmlString($expected, $htmlMenu);
        }

        public function test_should_return_separator()
        {
            $expected = '<li role="separator" class="divider"></li>';
            $label = '-';
            $position = 'left';
            $mainMenu = AppMenuManager::getInstance();
            $menu = new AppMenu('', $label, 0, '');
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
            $mainMenu = AppMenuManager::getInstance();
            $menu = new AppMenu('', $label, 0, '');
            $mainMenu->addMenu('Test', $menu, NULL);

            $subMenu = new AppMenu('#', 'test', 0, '');
            $mainMenu->addSubmenu('Test', $position, [$subMenu]);

            $htmlMenu = $this->Menus->displayMenuFor($position);
            $this->assertXmlStringEqualsXmlString($expected, trim($htmlMenu));
        }
    }
