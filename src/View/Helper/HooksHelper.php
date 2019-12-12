<?php

    namespace App\View\Helper;

    use App\Core\AppHookManager;
    use Cake\View\Helper;
    use Cake\View\View;

    /**
     * Hooks helper
     */
    class HooksHelper extends Helper
    {
        /**
         * Default configuration.
         *
         * @var array
         */
        protected $_defaultConfig = [];
        protected $pluginName = '';
        protected $controllerName = '';
        protected $actionName = '';

        public function __construct(View $View, array $config = [])
        {
            parent::__construct($View, $config);
            $this->pluginName = $View->getPlugin();
            $this->controllerName = $View->getName();
            $this->actionName = $View->getTemplate();
        }

        public function getHooks(String $anchor)
        {
            $hookManager = AppHookManager::getInstance();
            $hookeds = $hookManager->getHooks(implode('.', [$this->pluginName,
                                                            $this->controllerName,
                                                            $this->actionName,
                                                            $anchor]));
            $resultHtml = '';
            if (isset($hookeds['element'])) {
                foreach ($hookeds['element'] as $hooked) {
                    $resultHtml .= $this->getView()
                                        ->element($hooked);
                }
            }
            if (isset($hookeds['cell'])) {
                foreach ($hookeds['cell'] as $hooked) {
                    $resultHtml .= $this->getView()
                                        ->cell($hooked);
                }
            }
            return $resultHtml;
        }
    }
