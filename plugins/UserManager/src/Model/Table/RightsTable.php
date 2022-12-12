<?php

    namespace UserManager\Model\Table;

    use Cake\Datasource\EntityInterface;
    use Cake\ORM\Association\BelongsToMany;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;
    use UserManager\Model\Entity\Right;

    /**
     * Rights Model
     *
     * @property BelongsToMany $Groupes
     *
     * @method Right get($primaryKey, $options = [])
     * @method Right newEntity($data = NULL, array $options = [])
     * @method Right[] newEntities(array $data, array $options = [])
     * @method Right|bool save(EntityInterface $entity, $options = [])
     * @method Right patchEntity(EntityInterface $entity, array $data, array $options = [])
     * @method Right[] patchEntities($entities, array $data, array $options = [])
     * @method Right findOrCreate($search, callable $callback = NULL)
     */
    class RightsTable extends Table
    {

        /**
         * Initialize method
         *
         * @param array $config The configuration for the Table.
         * @return void
         */
        public function initialize(array $config): void
        {
            parent::initialize($config);

            $this->setTable('rights');
            $this->setDisplayField('label');
            $this->setPrimaryKey('id');

            $this->belongsToMany('Groups', [
                'foreignKey'       => 'rights_id',
                'targetForeignKey' => 'groups_id',
                'joinTable'        => 'rights_groups',
                'className'        => 'UserManager.Groups'
            ]);
        }

        /**
         * Default validation rules.
         *
         * @param Validator $validator Validator instance.
         * @return Validator
         */
        public function validationDefault(Validator $validator): Validator
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
         * @param RulesChecker $rules The rules object to be modified.
         * @return RulesChecker
         */
        public function buildRules(RulesChecker $rules): RulesChecker
        {
            $rules->add($rules->isUnique(['code'], ['message' => __('Ce code existe déjà')]));
            return $rules;
        }
    }
