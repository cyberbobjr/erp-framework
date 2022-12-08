<?php

    namespace Wizardinstaller\Controller;

    use App\Controller\AppController as BaseController;
    use Cake\Event\Event;
    use Cake\Event\EventInterface;

    /**
     * Class AppController
     * @package Wizardinstaller\Controller
     */
    class AppController extends BaseController
    {
        /**
         * @throws \Exception
         */
        public function initialize(): void
        {
            $this->loadComponent('Flash');
            $this->loadComponent('RequestHandler');
        }

        /**
         * Before render callback.
         *
         * @param Event $event The beforeRender event.
         * @return void
         */
        public function beforeRender(EventInterface $event): void
        {
            $this->viewBuilder()
                 ->setLayout('Wizardinstaller.default');
        }

    }
