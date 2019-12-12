<?php

    namespace OperationsManager\State;

    use OperationsManager\Exceptions\OperationsException;
    use OperationsManager\Model\Entity\Operation;

    class OpenState implements OpsState
    {
        public static function setNewState(Operation $operation): Operation
        {
            if ($operation->state === OpsStateEnum::$STATE_ARCHIVED) {
                throw new OperationsException(__('Une opération archivée ne peut pas être ouverte'));
            }
            $operation->state = OpsStateEnum::$STATE_OPEN;
            return $operation;
        }
    }
