<?php

    namespace OperationsManager\Model\Entity;

    use Cake\ORM\Entity;

    /**
     * Operationdetail Entity
     *
     * @property int $id
     * @property int $operation_id
     * @property string $label
     * @property float|null $total_included_vat
     * @property float|null $total_without_vat
     * @property float|null $total_vat
     * @property int $vat_id
     * @property float|null $vatrate
     * @property int $type_operationdetail_id
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     *
     * @property Operation $operation
     * @property TypeOperationdetail $typeoperationdetail
     * @property \App\Model\Entity\Vat $vat
     */
    class Operationdetail extends Entity
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
            'operation_id'            => TRUE,
            'label'                   => TRUE,
            'total_included_vat'      => TRUE,
            'total_without_vat'       => TRUE,
            'total_vat'               => TRUE,
            'vat_id'                  => TRUE,
            'vatrate'                 => TRUE,
            'type_operationdetail_id' => TRUE,
            'created'                 => TRUE,
            'modified'                => TRUE,
            'operation'               => TRUE,
            'typeoperationdetail'     => TRUE,
            'vat'                     => TRUE
        ];
    }
