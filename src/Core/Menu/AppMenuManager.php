<?php

    namespace App\Core\Menu;
    
    use Error;
    /**
     * Class MenuManager
     * @package App\Core
     */
    class AppMenuManager
    {
        private $_menu;
        private static $instance;
        /**
         * MenuManager constructor.
         * @param $_menu
         */
        private function __construct()
        {
            $this->_menu = ['left' => [], 'right' => []];
        }
        public static function getInstance()
        {
            if (empty(self::$instance)) {
                self::$instance = new \App\Core\Menu\AppMenuManager();
            }
            return self::$instance;
        }
        public function addMenu(string $pluginName, \App\Core\Menu\AppMenu $menu, $submenus, $position = 'left')
        {
            if (!is_a($menu, \App\Core\Menu\AppMenu::class)) {
                throw new \Error("You must pass a menu Object");
            }
            $menu = $menu->toArray();
            if (!isset($this->_menu[$position][$pluginName])) {
                $this->_menu[$position][$pluginName] = [];
            }
            $newMenu = ['icon' => $menu['icon'], 'label' => $menu['label'], 'url' => $menu['url'], 'order' => $menu['order'], 'submenus' => $this->_validateSubMenu($submenus)];
            $this->_menu[$position][$pluginName][] = $newMenu;
            return $newMenu;
        }
        public function getMenusWithPosition(string $position)
        {
            return $this->_menu[$position];
        }
        private function _validateSubMenu($submenus)
        {
            $validate = [];
            if (!isset($submenus)) {
                return $validate;
            }
            if (is_array($submenus)) {
                foreach ($submenus as $submenu) {
                    $validate[] = $this->_validateSubMenu($submenu);
                }
            } else {
                $validate = $submenus->toArray();
            }
            return $validate;
        }
        public function clearAll()
        {
            $this->_menu = [];
        }
        public function addSubmenu(string $menuName, string $position, array $array)
        {
            if (!isset($this->_menu[$position])) {
                $this->_menu[$position] = [$menuName => [['label' => $menuName, 'submenus' => []]]];
            } elseif (!isset($this->_menu[$position][$menuName])) {
                $this->_menu[$position][$menuName] = [['label' => $menuName, 'submenus' => []]];
            } elseif (!isset($this->_menu[$position][$menuName][0]['submenus'])) {
                $this->_menu[$position][$menuName][0]['submenus'] = [];
            }
            $this->_menu[$position][$menuName][0]['submenus'] = array_merge($this->_menu[$position][$menuName][0]['submenus'], $this->_validateSubMenu($array));
        }
    }


