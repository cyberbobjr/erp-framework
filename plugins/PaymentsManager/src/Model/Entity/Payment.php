<?php
namespace PaymentsManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reglement Entity
 *
 * @property int $id
 * @property int $banque_id
 * @property int $type_paiement_id
 * @property string $numero
 * @property string $commentaire
 * @property \Cake\I18n\FrozenDate $date
 * @property bool $compta
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Operation[] $operations
 * @property \App\Model\Entity\Banque $banque
 * @property \App\Model\Entity\TypePayment $type_paiement
 */
class Payment extends Entity
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
