<?php

    namespace App\Model\Table;

    use Cake\ORM\Table;

    class TypeSoldesTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->hasMany('Operations');
            $this->setDisplayField('libelle');
        }
    }

    ?>