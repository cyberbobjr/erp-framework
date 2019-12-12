<?php

    namespace App\Core\Entity;

    use App\Core\Form\FormType;

    class FieldDescriptor
    {
        private $_label;
        private $_type;
        private $_visible;

        /**
         * FieldDescriptor constructor.
         * @param $_label
         * @param $_visible
         * @param  FormType  $_type
         */
        private function __construct($_label, $_visible, $_type)
        {
            $this->_label = $_label;
            $this->_visible = $_visible;
            if ($_type !== NULL) {
                $this->_type = $_type;
            }
        }

        public static function set($_label, $_visible, $_type = NULL, ...$args)
        {
            return new FieldDescriptor($_label, $_visible, $_type);
        }

        /**
         * @return String
         */
        public function getLabel()
        {
            return $this->_label;
        }

        /**
         * @param  String  $label
         */
        public function setLabel(String $label): void
        {
            $this->_label = $label;
        }

        /**
         * @return mixed
         */
        public function getVisible()
        {
            return $this->_visible;
        }

        /**
         * @return FormType|null
         */
        public function getType()
        {
            return $this->_type;
        }

        /**
         * @param  mixed  $visible
         */
        public function setVisible($visible): void
        {
            $this->_visible = $visible;
        }

    }
