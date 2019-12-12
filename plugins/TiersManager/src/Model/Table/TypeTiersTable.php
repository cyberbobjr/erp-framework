<?php

    namespace TiersManager\Model\Table;

    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * TypeTiers Model
     *
     * @property TiersTable|\Cake\ORM\Association\HasMany $Tiers
     *
     * @method \TiersManager\Model\Entity\TypeTier get($primaryKey, $options = [])
     * @method \TiersManager\Model\Entity\TypeTier newEntity($data = NULL, array $options = [])
     * @method \TiersManager\Model\Entity\TypeTier[] newEntities(array $data, array $options = [])
     * @method \TiersManager\Model\Entity\TypeTier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \TiersManager\Model\Entity\TypeTier saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \TiersManager\Model\Entity\TypeTier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \TiersManager\Model\Entity\TypeTier[] patchEntities($entities, array $data, array $options = [])
     * @method \TiersManager\Model\Entity\TypeTier findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class TypeTiersTable extends Table
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

            $this->setTable('type_tiers');
            $this->setDisplayField('label');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');

            $this->hasMany('Tiers', [
                'foreignKey' => 'type_tier_id',
                'className'  => 'TiersManager.Tiers'
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
                ->scalar('label')
                ->maxLength('label', 255)
                ->requirePresence('label', 'create')
                ->allowEmptyString('label', FALSE);

            $validator
                ->integer('direction')
                ->allowEmptyString('direction');

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

            return $rules;
        }
    }
