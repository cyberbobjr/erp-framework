<?php

    namespace OperationsManager\State;

    class OpsStateEnum
    {
        public static $STATE_DRAFT = 1;
        public static $STATE_OPEN = 2;
        public static $STATE_CLOSED = 3;
        public static $STATE_CANCELLED = 4;
        public static $STATE_ARCHIVED = 5;

        public static function getLabelForState($state)
        {
            switch ($state) {
                case self::$STATE_DRAFT:
                    return __('Brouillon');
                case self::$STATE_OPEN:
                    return __('En cours');
                case self::$STATE_CLOSED:
                    return __('Clôturée');
                case self::$STATE_CANCELLED:
                    return __('Annulée');
                case self::$STATE_ARCHIVED:
                    return __('Archivée');
            }
        }
    }
