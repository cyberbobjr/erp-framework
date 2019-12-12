<?php
namespace TiersManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * TypeTier Entity
 *
 * @property int $id
 * @property string $label
 * @property int|null $direction
 * @property int|null $plan_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \TiersManager\Model\Entity\Plan $plan
 * @property \TiersManager\Model\Entity\Tier[] $tiers
 */
class TypeTier extends Entity
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
        'label' => true,
        'direction' => true,
        'plan_id' => true,
        'created' => true,
        'modified' => true,
        'plan' => true,
        'tiers' => true
    ];
}
