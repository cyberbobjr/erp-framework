<?php


    namespace OperationsManager\State;


    use OperationsManager\Model\Entity\Operation;

    interface OpsState
    {
        public static function setNewState(Operation $operation): Operation;
    }
