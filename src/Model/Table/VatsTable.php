<?php

    namespace App\Model\Table;

    use Cake\ORM\Table;

    /**
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class VatsTable extends Table
    {
        /**
         * Fonction d'initialisation de la table
         * @param array $config
         */
        public function initialize(array $config): void
        {
//            $this->addBehavior('Timestamp');
            $this->setDisplayField('rate');
        }
    }

?>
