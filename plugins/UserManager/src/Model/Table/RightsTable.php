<?php

    namespace UserManager\Model\Table;

    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * Rights Model
     *
     * @property \Cake\ORM\Association\BelongsToMany $Groupes
     *
     * @method \UserManager\Model\Entity\Right get($primaryKey, $options = [])
     * @method \UserManager\Model\Entity\Right newEntity($data = NULL, array $options = [])
     * @method \UserManager\Model\Entity\Right[] newEntities(array $data, array $options = [])
     * @method \UserManager\Model\Entity\Right|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \UserManager\Model\Entity\Right patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \UserManager\Model\Entity\Right[] patchEntities($entities, array $data, array $options = [])
     * @method \UserManager\Model\Entity\Right findOrCreate($search, callable $callback = NULL)
     */
    class RightsTable extends Table
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

            $this->setTable('rights');
            $this->setDisplayField('label');
            $this->setPrimaryKey('id');

            $this->belongsToMany('UserManager.Groupes', ['foreignKey'       => 'rights_id',
                                                         'targetForeignKey' => 'groupes_id',
                                                         'joinTable'        => 'rights_groupes',
                                                         'className'        => 'UserManager.Groupes'
            ]);
        }

        /**
         * Default validation rules.
         *
         * @param \Cake\Validation\Validator $validator Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator
                ->integer('id')
                ->isEmptyAllowed('id', TRUE);

            $validator
                ->requirePresence('code', 'create')
                ->isEmptyAllowed('code', FALSE);

            $validator
                ->isEmptyAllowed('libelle', FALSE);

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
            $rules->add($rules->isUnique(['code'], ['message' => __('Ce code existe déjà')]));
            return $rules;
        }
    }
