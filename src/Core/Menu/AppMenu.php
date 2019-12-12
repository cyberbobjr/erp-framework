<?php


    namespace App\Core\Menu;


    class AppMenu
    {
        /**
         * @return mixed
         */
        public function getUrl()
        {
            return $this->_url;
        }

        /**
         * @return mixed
         */
        public function getLabel()
        {
            return $this->_label;
        }

        /**
         * @return mixed
         */
        public function getOrder()
        {
            return $this->_order;
        }

        /**
         * @return mixed
         */
        public function getIcon()
        {
            return $this->_icon;
        }

        private $_url;
        private $_label;
        private $_order;
        private $_icon;

        /**
         * Menu constructor.
         * @param $url
         * @param $label
         * @param $order
         * @param $icon
         */
        public function __construct($url, $label, $order, $icon)
        {
            $this->_url = $url;
            $this->_label = $label;
            $this->_order = $order;
            $this->_icon = $icon;
        }

        /**
         * @return array
         */
        public function toArray()
        {
            return [
                'url'   => $this->_url,
                'label' => $this->_label,
                'order' => $this->_order,
                'icon'  => $this->_icon,
            ];
        }
    }
