<?php

    namespace App\View\Helper;

    use App\Core\Menu\AppMenuManager;
    use Cake\View\Helper;

    /**
     * Menus helper
     */
    class MenusHelper extends Helper
    {
        /**
         * Default configuration.
         *
         * @var array
         */
        protected $_defaultConfig = [];

        public function displayMenuFor($position)
        {
            $resultHtml = '';
            $menus = AppMenuManager::getInstance();
            foreach ($menus->getMenusWithPosition($position) as $menuNames) {
                foreach ($menuNames as $plugin) {
                    if (count($plugin['submenus']) > 0) {
                        $resultHtml .= '
                            <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.(!empty($plugin['icon']) ? $plugin['icon'].' ' : '').$plugin['label'].' <span class="caret"></span></a>
                            <div class="dropdown-menu">';
                        foreach ($plugin['submenus'] as $submenu) {
                            if ($submenu['label'] === '-') {
                                $resultHtml .= ' <div class="dropdown-divider"></div>';
                            } else {
                                $resultHtml .= "<a class=\"dropdown-item\"  href='".$submenu['url']."'>".$submenu['label'].'</a>';
                            }
                        }
                        $resultHtml .= '</div></li>';
                    } else {
                        if ($plugin['label'] === '-') {
                            $resultHtml .= '<li role="separator" class="divider"></li>';
                        } else {
                            $resultHtml .= "<li class=\"nav-item\"><a href='".$plugin['url']."'>".(!empty($plugin['icon']) ? $plugin['icon'].' ' : '').$plugin['label'].'</a></li>';
                        }
                    }
                }
            }
            return $resultHtml;
        }
    }
