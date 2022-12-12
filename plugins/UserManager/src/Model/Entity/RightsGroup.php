<?php
namespace UserManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * DroitsGroupe Entity
 *
 * @property int $droits_id
 * @property int $goupes_id
 *
 * @property Right $droit
 * @property Group $groupe
 */
class RightsGroup extends Entity
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
        'rights_id' => false,
        'groups_id' => false
    ];
}
