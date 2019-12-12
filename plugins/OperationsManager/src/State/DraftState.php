<?php

    namespace OperationsManager\State;

    use OperationsManager\Exceptions\OperationsException;
    use OperationsManager\Model\Entity\Operation;

    class DraftState implements OpsState
    {
        /**
         * @param  Operation  $operation
         * @return Operation
         * @throws OperationsException
         */
        public static function setNewState(Operation $operation): Operation
        {
            if (!isset($operation->state)) {
                $operation->state = OpsStateEnum::$STATE_DRAFT;
                return $operation;
            }
            throw new OperationsException(__('Une opération ne peut pas revenir en mode brouillon'));
        }
    }
