<?php

    namespace OperationsManager\Test\Factory;

    use OperationsManager\Test\TypeOpsEnum;

    class OpsFactory
    {
        public static function createOps(Array $data, int $type_ops)
        {
            switch ($type_ops) {
                case TypeOpsEnum::OP_CUSTOMER_RENT :
                    $data['type_op_id'] = TypeOpsEnum::OP_CUSTOMER_RENT;
                    break;
                case TypeOpsEnum::OP_CUSTOMER_INVOICE :
                    $data['type_op_id'] = TypeOpsEnum::OP_CUSTOMER_INVOICE;
                    break;
            }
            return $data;
        }
    }
