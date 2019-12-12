<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TypePeriodicite Entity
 *
 * @property int $id
 * @property string $libelle
 */
class TypePeriodicite extends Entity
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

    public const FIELD_ID = 'id';
    public const FIELD_LIBELLE = 'libelle';
}
