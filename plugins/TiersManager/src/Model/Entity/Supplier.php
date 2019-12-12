<?php

    namespace TiersManager\Model\Entity;

    use Cake\ORM\Entity;

    /**
     * Supplier Entity
     *
     * @property int $id
     * @property int $type_tier_id
     * @property string|null $lastname
     * @property string|null $firstname
     * @property string|null $company_name
     * @property bool $vat
     * @property string|null $address1
     * @property string|null $address2
     * @property string|null $zipcode
     * @property string|null $city
     * @property string|null $phonenumber
     * @property string|null $mobilenumber
     * @property string|null $officenumber
     * @property string|null $comments
     * @property string|null $vat_intra
     * @property string|null $email
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     *
     * @property \App\Model\Entity\TypeTier $type_tier
     * @property \App\Model\Entity\Operation[] $operations
     * @property \App\Model\Entity\Paiement[] $paiements
     * @property \App\Model\Entity\Documentstier[] $documentstiers
     * @property \App\Model\Entity\Bail[] $bails
     */
    class Supplier extends Entity
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
            'type_tier_id'   => TRUE,
            'lastname'       => TRUE,
            'firstname'      => TRUE,
            'company_name'   => TRUE,
            'vat'            => TRUE,
            'address1'       => TRUE,
            'address2'       => TRUE,
            'zipcode'        => TRUE,
            'city'           => TRUE,
            'phonenumber'    => TRUE,
            'mobilenumber'   => TRUE,
            'officenumber'   => TRUE,
            'comments'       => TRUE,
            'vat_intra'      => TRUE,
            'email'          => TRUE,
            'created'        => TRUE,
            'modified'       => TRUE,
            'type_tier'      => TRUE,
            'operations'     => TRUE,
            'paiements'      => TRUE,
            'documentstiers' => TRUE,
            'bails'          => TRUE
        ];
    }
