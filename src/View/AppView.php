<?php
    /**
     * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
     * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     * @link      http://cakephp.org CakePHP(tm) Project
     * @since     3.0.0
     * @license   http://www.opensource.org/licenses/mit-license.php MIT License
     */

    namespace App\View;

    use App\View\Helper\HooksHelper;
    use App\View\Helper\MenusHelper;
    use App\View\Helper\UtilityHelper;
    use BootstrapUI\View\Helper\FlashHelper;
    use BootstrapUI\View\Helper\FormHelper;
    use BootstrapUI\View\Helper\HtmlHelper;
    use BootstrapUI\View\Helper\PaginatorHelper;
    use BootstrapUI\View\UIViewTrait;
    use Cake\View\View;

    /**
     * Application View
     *
     * Your application’s default view class
     *
     * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
     * @property HtmlHelper      $Html
     * @property FormHelper      $Form
     * @property FlashHelper     $Flash
     * @property PaginatorHelper $Paginator
     * @property UtilityHelper   $Utility
     * @property HooksHelper     $Hooks
     * @property MenusHelper     $Menus
     */
    class AppView extends View
    {
        use UIViewTrait;

        /**
         * Initialization hook method.
         *
         * Use this method to add common initialization code like loading helpers.
         *
         * e.g. `$this->loadHelper('Html');`
         *
         * @return void
         */
        public function initialize(): void
        {
            parent::initialize();
            $this->loadHelper('Number');
            $this->loadHelper('Utility');
            $this->loadHelper('Menus');
            $this->loadHelper('Hooks');
        }
    }