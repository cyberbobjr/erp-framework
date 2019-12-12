<?php

    namespace PropertiesManager\Model\Entity;

    use Cake\ORM\Entity;

    /**
     * Property Entity
     *
     * @property int $id
     * @property string $designation
     * @property string $address
     * @property string $address2
     * @property string zipcode
     * @property string $city
     * @property int $numberlot
     * @property int $floor
     * @property string $number
     * @property int $building
     * @property string $comments
     * //     * @property int $societe_id
     * //     * @property int $bail_id
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     *
     * //     * @property \App\Model\Entity\Lease[] $bails
     * //     * @property \App\Model\Entity\Company $societe
     */
    class Property extends Entity
    {

        /**
         * Fields that can be mass assigned using newEntity() or patchEntity().
         *
         * Note that when '*' is set to true, this allows all unspecified fields to
         * be mass assigned. For security purposes, it is advised to set '*' to false
         * (or remove it), and explicitly make individual fields accessible as needed.
         *
         * @var array
         */
        protected $_accessible = ['*'  => TRUE,
                                  'id' => FALSE];
//        protected $_virtual = ['bail_actif'];

        /*protected function _getBailActif()
        {
            $BailsTable = TableRegistry::get('Bails');
            $bail = $BailsTable->find()
                               ->where(['bien_id' => $this->_properties['id'],
                                        'actif'   => TRUE])
                               ->first();
            return $bail;
        }*/
    }
