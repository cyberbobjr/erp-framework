<?php

    namespace App\Model\Entity;

    use Cake\ORM\Entity;

    class Tier extends Entity
    {
        protected $_accessible = ['*' => TRUE,];
        protected $_virtual = ['lastname_complet'];

        protected function _getNomComplet()
        {
            if (isset($this->_properties['comany_name']) || isset($this->_properties['lastname']))
                return $this->_properties['comany_name'] . '  ' . $this->_properties['lastname'] . ' ' . $this->_properties['firstname'];
        }
    }

    ?>
