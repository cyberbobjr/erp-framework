<?php
namespace LeasesManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * Loyerdetail Entity
 *
 * @property int $id
 * @property int $loyer_id
 * @property string $libelle
 * @property int $type_operation_id
 * @property float $montant_ttc
 * @property float $montant_ht
 * @property int $tva_id
 * @property float $montant_tva
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Rent $loyer
 */
class Rentdetail extends Entity
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
        '*' => true,
        'id' => false
    ];
}
