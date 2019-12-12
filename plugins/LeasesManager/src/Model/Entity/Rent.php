<?php
namespace LeasesManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * Loyer Entity
 *
 * @property int $id
 * @property int $bail_id
 * @property bool $ref
 * @property float $total_ttc
 * @property float $total_ht
 * @property float $total_tva
 * @property string $commentaire
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Lease $bail
 * @property \App\Model\Entity\Rentdetail[] $loyerdetails
 */
class Rent extends Entity
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
