<?php

    namespace PropertiesManager\Model\Table;

    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;
    use PropertiesManager\Model\Entity\Property;

    /**
     * Biens Model
     *
     * @property \App\Model\Table\CompaniesTable|\Cake\ORM\Association\BelongsTo $Societes
     * @property \App\Model\Table\LeasesTable|\Cake\ORM\Association\HasMany $Bails
     *
     * @method Property get($primaryKey, $options = [])
     * @method Property newEntity($data = NULL, array $options = [])
     * @method Property[] newEntities(array $data, array $options = [])
     * @method Property|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method Property patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method Property[] patchEntities($entities, array $data, array $options = [])
     * @method Property findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class PropertiesTable extends Table
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

            $this->setTable('properties');
            $this->setDisplayField('designation');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');
//            $this->belongsTo('Companies', ['foreignKey' => 'societe_id']);
//            $this->hasMany('Leases', ['foreignKey' => 'property_id']);
        }

        /**
         * Default validation rules.
         *
         * @param \Cake\Validation\Validator $validator Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator->integer('id')
                      ->requirePresence('id', 'update');

            $validator->requirePresence('designation', 'create');

            $validator->requirePresence('address1', TRUE);

            $validator->isEmptyAllowed('address2', TRUE);

            $validator->requirePresence('zipcode', TRUE);

            $validator->requirePresence('city', TRUE);

            $validator->integer('lotnumber')
                      ->isEmptyAllowed('lotnumber', TRUE);

            $validator->integer('floor')
                      ->isEmptyAllowed('floor', TRUE);

            $validator->isEmptyAllowed('number', TRUE);

            $validator->integer('building')
                      ->isEmptyAllowed('building', TRUE);

            return $validator;
        }

        /**
         * Returns a rules checker object that will be used for validating
         * application integrity.
         *
         * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
         * @return \Cake\ORM\RulesChecker
         */
        public function buildRules(RulesChecker $rules)
        {
//            $rules->add($rules->existsIn(['societe_id'], 'Societes'));
//            $rules->add($rules->existsIn(['bail_id'], 'Bails'));

            return $rules;
        }
    }
