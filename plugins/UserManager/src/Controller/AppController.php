<?php

    namespace UserManager\Controller;

    use App\Controller\AppController as BaseController;
    use Cake\Controller\Component\AuthComponent;
    use Cake\Core\Configure;
    use Cake\Event\EventInterface;

    /**
     * Class AppController
     *
     * @property      AuthComponent $Auth
     * @package UserManager\Controller
     */
    class AppController extends BaseController
    {
        protected $_registerRedirect = [
            'plugin'     => 'SubscriptionManager',
            'controller' => 'offers',
            'action'     => 'step1'
        ];

        public function initialize(): void
        {
            $this->loadComponent('Flash');
            $this->loadComponent('RequestHandler');
            $this->loadComponent(
                'Auth',
                [
                    'flash'                => ['element' => 'default'],
                    'authenticate'         => [
                        'Form' => [
                            'userModel' => 'UserManager.Users',
                            'finder'    => 'auth',
                            'fields'    => [
                                'username' => 'username',
                                'password' => 'password'
                            ]
                        ]
                    ],
                    'authError'            => __('Vous ne possédez pas l\'autorisation d\'accéder à cette page'),
                    'authorize'            => ['Controller'],
                    'checkAuthIn'          => 'Controller.initialize',
                    'unauthorizedRedirect' => $this->referer(),
                    'loginRedirect'        => [
                        'controller' => 'Dashboards',
                        'action'     => 'index',
                        'plugin'     => NULL
                    ],
                    'loginAction'          => [
                        'plugin'     => $this->plugin,
                        'controller' => 'users',
                        'action'     => 'login'
                    ],
                    'logoutRedirect'       => [
                        'plugin'     => $this->plugin,
                        'controller' => 'users',
                        'action'     => 'login'
                    ],
                    'sessionKey'           => 'User'
                ]
            );
            if (!is_null(Configure::read('UserManager.allowRegistration')) && !Configure::read('UserManager.allowRegistration')) {
                $this->Auth->deny('register');
            }
        }

        public function isAuthorized($user): bool
        {
            return TRUE;
        }

        /**
         * Fonction executée avant l'affichage
         * Elle permet de selectionner la barre de navigation à afficher pour le layout
         *
         * @param  EventInterface  $event
         * @return void
         */
        public function beforeFilter(EventInterface $event): void
        {
            // Si l'utilisateur est enregistré, nous affichons la barre de menu complète
            if (!$this->Auth->user()) {
                $this->viewBuilder()
                     ->setLayout('UserManager.login');
            }
        }
    }
