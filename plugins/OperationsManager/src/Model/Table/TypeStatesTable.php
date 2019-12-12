<?php

    namespace OperationsManager\Model\Table;

    use Cake\ORM\Table;

    /**
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class TypeStatesTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->setDisplayField('label');
            $this->setTable('type_op_states');
        }
    }
