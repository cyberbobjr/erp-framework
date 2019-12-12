<?php

    namespace TiersManager\Model\Table;

    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * CustomerExtends Model
     *
     * @property TiersTable|\Cake\ORM\Association\BelongsTo $Tiers
     *
     * @method \TiersManager\Model\Entity\CustomerExtend get($primaryKey, $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend newEntity($data = null, array $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend[] newEntities(array $data, array $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend[] patchEntities($entities, array $data, array $options = [])
     * @method \TiersManager\Model\Entity\CustomerExtend findOrCreate($search, callable $callback = null, $options = [])
     */
    class CustomerExtendsTable extends Table
    {
        /**
         * Initialize method
         *
         * @param  array  $config  The configuration for the Table.
         * @return void
         */
        public function initialize(array $config)
        {
            parent::initialize($config);

            $this->setTable('customer_extends');
            $this->setPrimaryKey('id');

            $this->belongsTo('TiersManager.Customers', [
                'foreignKey' => 'tier_id',
                'joinType'   => 'INNER',
                'className'  => 'TiersManager.Customers'
            ]);
        }

        /**
         * Default validation rules.
         *
         * @param  Validator  $validator  Validator instance.
         * @return Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator
                ->integer('id')
                ->allowEmptyString('id', 'create');

            return $validator;
        }

        /**
         * Returns a rules checker object that will be used for validating
         * application integrity.
         *
         * @param  \Cake\ORM\RulesChecker  $rules  The rules object to be modified.
         * @return \Cake\ORM\RulesChecker
         */
        public function buildRules(RulesChecker $rules)
        {
            $rules->add($rules->existsIn(['tier_id'], 'Customers'));

            return $rules;
        }
    }
