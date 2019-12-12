<?php

    namespace OperationsManager\Model\Entity;


    use App\Core\Entity\AppEntity;

    /**
     * Operation Entity
     *
     * @property int $id
     * @property int|null $lease_id
     * @property int|null $company_id
     * @property int $tier_id
     * @property int $type_op_id
     * @property string $label
     * @property float|null $total_included_vat
     * @property float|null $total_without_vat
     * @property float|null $total_vat
     * @property bool $vat
     * @property \Cake\I18n\FrozenDate|null $due_date
     * @property bool $draft
     * @property string|null $commentspublic
     * @property string|null $commentsprivate
     * @property bool $accounted
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     * @property float|null $balance
     * @property int|null $state
     *
     * @property \OperationsManager\Model\Entity\TypeState $type_state
     * @property \OperationsManager\Model\Entity\TypeOp $type_op
     * @property \OperationsManager\Model\Entity\Operationdetail[] $operationdetails
     * @property \PaymentsManager\Model\Entity\Payment[] $payments
     * @property \TiersManager\Model\Entity\Customer $customer
     * @property \CompaniesManager\Model\Entity\Company $company
     * @property \LeasesManager\Model\Entity\Lease $lease
     */
    class Operation extends AppEntity
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
            'lease_id'           => TRUE,
            'company_id'         => TRUE,
            'tier_id'            => TRUE,
            'type_op_id'         => TRUE,
            'label'              => TRUE,
            'total_included_vat' => TRUE,
            'total_without_vat'  => TRUE,
            'total_vat'          => TRUE,
            'vat'                => TRUE,
            'due_date'           => TRUE,
            'draft'              => TRUE,
            'commentspublic'     => TRUE,
            'commentsprivate'    => TRUE,
            'accounted'          => TRUE,
            'created'            => TRUE,
            'modified'           => TRUE,
            'balance'            => TRUE,
            'state'              => TRUE,
            'type_state'         => TRUE,
            'type_op'            => TRUE,
            'operationdetails'   => TRUE,
            'payments'           => TRUE,
            'customer'           => TRUE,
            'company'            => TRUE,
            'lease'              => TRUE
        ];
    }
