<?php

    namespace App\Model\Entity;


    use App\Core\Entity\AppEntity;

    /**
     * Vat Entity
     *
     * @property int $id
     * @property float $rate
     */
    class Vat extends AppEntity
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
        protected $_accessible = [
            'rate' => TRUE
        ];
    }
