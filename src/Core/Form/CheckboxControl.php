<?php

    namespace App\Core\Form;

    class CheckboxControl implements FormType
    {
        public static function getOptions()
        {
            return ['type' => 'checkbox'];
        }

    }
