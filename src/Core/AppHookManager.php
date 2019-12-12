<?php


    namespace App\Core;


    class AppHookManager
    {
        private static $instance;
        private $hooks;

        public static function getInstance()
        {
            if (empty(self::$instance)) {
                self::$instance = new AppHookManager();
            }
            return self::$instance;
        }

        private function __construct()
        {

        }

        public function addHook($hooked, $element, $type = 'element')
        {
            try {
                $this->hooks[$hooked][$type][] = $element;
                return TRUE;
            } catch (\Exception $ex) {
                return FALSE;
            }
        }

        public function getHooks($hooked)
        {
            return $this->hooks[$hooked] ?? [];
        }

        public function clear()
        {
            $this->hooks = [];
        }
    }
