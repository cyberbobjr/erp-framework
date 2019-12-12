<?php

    namespace TiersManager\Model\Table;

    use App\Core\AppConstants;
    use ArrayObject;
    use Cake\Event\Event;
    use Cake\ORM\Query;
    use Cake\ORM\RulesChecker;
    use Cake\Validation\Validator;

    /**
     * Suppliers Model
     *
     * @property \App\Model\Table\TypeTiersTable|\Cake\ORM\Association\BelongsTo $TypeTiers
     * @property |\Cake\ORM\Association\HasMany $Invoices
     * @property |\Cake\ORM\Association\HasMany $Leases
     *
     * @method \TiersManager\Model\Entity\Supplier get($primaryKey, $options = [])
     * @method \TiersManager\Model\Entity\Supplier newEntity($data = NULL, array $options = [])
     * @method \TiersManager\Model\Entity\Supplier[] newEntities(array $data, array $options = [])
     * @method \TiersManager\Model\Entity\Supplier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \TiersManager\Model\Entity\Supplier saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \TiersManager\Model\Entity\Supplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \TiersManager\Model\Entity\Supplier[] patchEntities($entities, array $data, array $options = [])
     * @method \TiersManager\Model\Entity\Supplier findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class SuppliersTable extends TiersTable
    {
        /**
         * Initialize method
         *
         * @param array $config The configuration for the Table.
         * @return void
         */
        public function initialize(array $config)
        {
            parent::initialize($config);

            $this->setTable('tiers');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');

            $this->belongsTo('TypeTiers', [
                'foreignKey' => 'type_tier_id',
                'joinType'   => 'INNER',
                'className'  => 'TiersManager.TypeTiers'
            ]);
        }

        /**
         * Default validation rules.
         *
         * @param Validator $validator Validator instance.
         * @return Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator
                ->integer('id')
                ->allowEmptyString('id', 'create');

            $validator
                ->scalar('lastname')
                ->maxLength('lastname', 255)
                ->allowEmptyString('lastname');

            $validator
                ->scalar('firstname')
                ->maxLength('firstname', 255)
                ->allowEmptyString('firstname');

            $validator
                ->scalar('company_name')
                ->maxLength('company_name', 255)
                ->allowEmptyString('company_name');

            $validator
                ->boolean('vat')
                ->allowEmptyString('vat', FALSE);

            $validator
                ->scalar('address1')
                ->maxLength('address1', 255)
                ->allowEmptyString('address1');

            $validator
                ->scalar('address2')
                ->maxLength('address2', 255)
                ->allowEmptyString('address2');

            $validator
                ->scalar('zipcode')
                ->maxLength('zipcode', 255)
                ->allowEmptyString('zipcode');

            $validator
                ->scalar('city')
                ->maxLength('city', 255)
                ->allowEmptyString('city');

            $validator
                ->scalar('phonenumber')
                ->maxLength('phonenumber', 255)
                ->allowEmptyString('phonenumber');

            $validator
                ->scalar('mobilenumber')
                ->maxLength('mobilenumber', 255)
                ->allowEmptyString('mobilenumber');

            $validator
                ->scalar('officenumber')
                ->maxLength('officenumber', 255)
                ->allowEmptyString('officenumber');

            $validator
                ->scalar('comments')
                ->allowEmptyString('comments');

            $validator
                ->scalar('vat_intra')
                ->maxLength('vat_intra', 255)
                ->allowEmptyString('vat_intra');

            $validator
                ->email('email')
                ->allowEmptyString('email');

            return $validator;
        }

        /**
         * Returns a rules checker object that will be used for validating
         * application integrity.
         *
         * @param RulesChecker $rules The rules object to be modified.
         * @return RulesChecker
         */
        public function buildRules(RulesChecker $rules)
        {
            $rules->add($rules->isUnique(['email']));
            $rules->add($rules->existsIn(['type_tier_id'], 'TypeTiers'));

            return $rules;
        }

        public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
        {
            $data['type_tier_id'] = AppConstants::SUPPLIER;
        }

        public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary)
        {
            return $query->where(['type_tier_id' => AppConstants::SUPPLIER]);
        }
    }
