<?php

    namespace LeasesManager\Model\Entity;

    use Cake\ORM\Entity;

    /**
     * Bail Entity
     *
     * @property int $id
     * @property string $designation
     * @property int $societe_id
     * @property int $tva_id
     * @property int $bien_id
     * @property int $tier_id
     * @property int $type_periodicite_id
     * @property int $loyer_id
     * @property \Cake\I18n\FrozenDate $date_debut
     * @property \Cake\I18n\FrozenDate $date_fin
     * @property bool $planif
     * @property float $valeur_indice
     * @property int $indice_id
     * @property string $commentaire
     * @property bool $actif
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     *
     * @property \App\Model\Entity\Operation[] $operations
     * @property \App\Model\Entity\Property $bien
     * @property \App\Model\Entity\Customer $client
     * @property \App\Model\Entity\Company $societe
     * @property \App\Model\Entity\TypePeriodicite $type_periodicite
     * @property \App\Model\Entity\Rent $loyer
     */
    class Lease extends Entity
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
