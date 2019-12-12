<?php

    namespace DocumentsManager\Model\Table;

    use Cake\Event\Event;
    use Cake\ORM\Entity;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * Documents Model
     *
     * @property \App\Model\Table\OperationsTable|\Cake\ORM\Association\BelongsTo $Operations
     *
     * @method \App\Model\Entity\Document get($primaryKey, $options = [])
     * @method \App\Model\Entity\Document newEntity($data = NULL, array $options = [])
     * @method \App\Model\Entity\Document[] newEntities(array $data, array $options = [])
     * @method \App\Model\Entity\Document|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\Document patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \App\Model\Entity\Document[] patchEntities($entities, array $data, array $options = [])
     * @method \App\Model\Entity\Document findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class DocumentsTable extends Table
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

            $this->setTable('documents');
            $this->setDisplayField('label');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');
        }

        /**
         * Default validation rules.
         *
         * @param  \Cake\Validation\Validator  $validator  Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

            $validator
                ->requirePresence('file', 'create')
                ->notEmpty('file');

            $validator
                ->integer('type')
                ->requirePresence('type', 'create')
                ->notEmpty('type');

            $validator
                ->requirePresence('libelle', 'create')
                ->notEmpty('libelle');

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
            $rules->add($rules->existsIn(['operation_id'], 'Operations'));
            return $rules;
        }

        public function afterDelete(Event $event, Entity $entity, $options)
        {
            if (file_exists(ROOT.DS.'PDF'.DS.$entity->file.'.pdf')) {
                unlink(ROOT.DS.'PDF'.DS.$entity->file.'.pdf');
            }
        }
    }
