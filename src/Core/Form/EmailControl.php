<?php

    namespace App\Core\Form;

    class EmailControl implements FormType
    {
        public static function getOptions()
        {
            return ['type' => 'email'];
        }

    }
