<?php
    /**
     * Created by IntelliJ IDEA.
     * User: benjaminmarchandkeyeirl
     * Date: 2019-03-08
     * Time: 13:58
     */

    namespace OperationsManager\Model\Entity;


    use Cake\ORM\Entity;

    /**
 * @property int $id
 * @property string $libelle
 * @property int $sens_tiers
 * @property int $sens_societe
 * @property int|null $plan_id
 * @property int $code_tiers
 * @property bool $loyer
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\ORM\Entity $plancompta
 */
class TypeOperationDetail extends Entity
    {
        protected $_accessible = [
            '*'  => TRUE,
            'id' => FALSE
        ];
    }