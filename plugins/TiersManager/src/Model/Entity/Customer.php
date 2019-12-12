<?php

    namespace TiersManager\Model\Entity;

    use App\Core\Entity\AppEntity;
    use App\Core\Entity\FieldDescriptor;
    use App\Core\Form\CheckboxControl;
    use App\Core\Form\EmailControl;

    /**
     * Customer Entity
     *
     * @property int $id
     * @property int $type_tier_id
     * @property string|null $lastname
     * @property string|null $firstname
     * @property string|null $company_name
     * @property boolean $vat
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
     * @property string|null $picture
     * @property CustomerExtend[]|null $customer_extends
     * @property \Cake\I18n\FrozenTime $created
     * @property \Cake\I18n\FrozenTime $modified
     *
     * @property \App\Model\Entity\TypeTier $type_tier
     */
    class Customer extends AppEntity
    {
        protected $_hidden = ['type_tier_id'];
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
            'id'               => FALSE,
            'type_tier_id'     => TRUE,
            'lastname'         => TRUE,
            'firstname'        => TRUE,
            'email'            => TRUE,
            'company_name'     => TRUE,
            'vat'              => TRUE,
            'address1'         => TRUE,
            'address2'         => TRUE,
            'zipcode'          => TRUE,
            'city'             => TRUE,
            'phonenumber'      => TRUE,
            'mobilenumber'     => TRUE,
            'officenumber'     => TRUE,
            'comments'         => TRUE,
            'vat_intra'        => TRUE,
            'created'          => FALSE,
            'modified'         => FALSE,
            'customer_extends' => TRUE
        ];

        public function __construct(array $properties = [], array $options = [])
        {
            parent::__construct($properties, $options);
            $this->_fieldControls = [
                'lastname'     => FieldDescriptor::set(__('Nom :'), TRUE),
                'firstname'    => FieldDescriptor::set(__('Prénom :'), TRUE),
                'email'        => FieldDescriptor::set(__('Email :'), TRUE, EmailControl::class),
                'company_name' => FieldDescriptor::set(__('Société :'), TRUE),
                'address1'     => FieldDescriptor::set(__('Adresse :'), TRUE),
                'address2'     => FieldDescriptor::set(__('Adresse (complément) :'), TRUE),
                'zipcode'      => FieldDescriptor::set(__('Code postal :'), TRUE),
                'city'         => FieldDescriptor::set(__('Ville :'), TRUE),
                'phonenumber'  => FieldDescriptor::set(__('Téléphone fixe :'), TRUE),
                'mobilenumber' => FieldDescriptor::set(__('Téléphone mobile :'), TRUE),
                'officenumber' => FieldDescriptor::set(__('Téléphone bureau :'), TRUE),
                'comments'     => FieldDescriptor::set(__('Commentaires :'), TRUE),
                'vat'          => FieldDescriptor::set(__('Soumis à la TVA'), TRUE, CheckboxControl::class),
                'vat_intra'    => FieldDescriptor::set(__('Numéro de TVA intracommunautaire :'), TRUE),
                'type_tier_id' => FieldDescriptor::set(__(''), FALSE),
            ];
        }

        protected function _getFullname()
        {
            return trim(implode(' ', [$this->get('firstname'),
                                      $this->get('lastname'),
                                      $this->get('company_name')]));
        }

        public function isNameInfosValid()
        {
            return !empty($this->_getFullname());
        }
    }
