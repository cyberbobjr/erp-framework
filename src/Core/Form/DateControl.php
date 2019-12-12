<?php

    namespace App\Core\Form;

    class DateControl implements FormType
    {
        public static function getOptions()
        {
            return ['type'      => 'text',
                    'data-role' => 'datepicker'];
        }

    }
