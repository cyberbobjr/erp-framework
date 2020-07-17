<?php

    /**
     * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
     * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     *
     * Licensed under The MIT License
     * For full copyright and license information, please see the LICENSE.txt
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     * @link          http://cakephp.org CakePHP(tm) Project
     * @since         0.2.9
     * @license       http://www.opensource.org/licenses/mit-license.php MIT License
     */

    namespace App\Controller;

    use Cake\Controller\Controller;
    use Cake\ORM\Table;
    use UserManager\Model\Table\UsersTable;

    /**
     * Application Controller
     *
     * Add your application-wide methods in the class below, your controllers
     * will inherit them.
     *
     * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
     * @property UsersTable $Users
     * @property Table      $Operations
     * @property Table      $Documents
     */
    class AppController extends Controller
    {
        /**
         * Initialization hook method.
         *
         * Use this method to add common initialization code like loading components.
         *
         * @return void
         * @throws \Exception
         */
        public function initialize(): void
        {
            parent::initialize();
            $this->loadComponent('RequestHandler');
            $this->loadComponent('Flash');
            $this->loadComponent('Paginator');
        }
    }
