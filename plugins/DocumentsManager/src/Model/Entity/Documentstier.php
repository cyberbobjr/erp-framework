<?php

    namespace DocumentsManager\Model\Entity;

    use Cake\ORM\Entity;

    /**
     * Documentstier Entity
     *
     * @property int $id
     * @property int $tier_id
     * @property int $bail_id
     * @property string $file
     * @property int $type
     * @property string $libelle
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     *
     * @property \App\Model\Entity\Tier $tier
     */
    class Documentstier extends Entity
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
    }
