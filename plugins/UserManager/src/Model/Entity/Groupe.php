<?php

    namespace UserManager\Model\Entity;

    use Cake\ORM\Entity;

    /**
     * Groupe Entity
     *
     * @property int $id
     * @property string $label
     * @property string|null $description
     *
     * @property Right[] $droits
     * @property User[] $users
     * @property Right[] $rights
     */
    class Groupe extends Entity
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
            '*'  => TRUE,
            'id' => FALSE
        ];
    }
