<?php

    namespace LeasesManager\Model\Table;

    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * TypePeriodicites Model
     *
     * @property |\Cake\ORM\Association\HasMany $Bails
     *
     * @method \App\Model\Entity\TypePeriodicite get($primaryKey, $options = [])
     * @method \App\Model\Entity\TypePeriodicite newEntity($data = NULL, array $options = [])
     * @method \App\Model\Entity\TypePeriodicite[] newEntities(array $data, array $options = [])
     * @method \App\Model\Entity\TypePeriodicite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\TypePeriodicite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \App\Model\Entity\TypePeriodicite[] patchEntities($entities, array $data, array $options = [])
     * @method \App\Model\Entity\TypePeriodicite findOrCreate($search, callable $callback = NULL, $options = [])
     */
    class TypePeriodicitesTable extends Table
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

            $this->setTable('type_periodicites');
            $this->setDisplayField('libelle');
            $this->setPrimaryKey('id');

            $this->hasMany('Bails', ['foreignKey' => 'type_periodicite_id']);
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
                      ->allowEmpty('id', 'create');

            $validator->requirePresence('libelle', 'create')
                      ->notEmpty('libelle');

            return $validator;
        }
    }
