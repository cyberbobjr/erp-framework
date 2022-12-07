<?php

    namespace App\Model\Table;

    use Cake\ORM\Query;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * Configs Model
     *
     * @property \App\Model\Table\OrganisationsTable|\Cake\ORM\Association\BelongsToMany $Organisations
     *
     * @method \App\Model\Entity\Config get($primaryKey, $options = [])
     * @method \App\Model\Entity\Config newEntity($data = NULL, array $options = [])
     * @method \App\Model\Entity\Config[] newEntities(array $data, array $options = [])
     * @method \App\Model\Entity\Config|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\Config saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\Config patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \App\Model\Entity\Config[] patchEntities($entities, array $data, array $options = [])
     * @method \App\Model\Entity\Config findOrCreate($search, callable $callback = NULL, $options = [])
     */
    class ConfigsTable extends Table
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

            $this->setTable('configs');
            $this->setDisplayField('id');
            $this->setPrimaryKey('id');
        }

        /**
         * Default validation rules.
         *
         * @param \Cake\Validation\Validator $validator Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator): \Cake\Validation\Validator
        {
            $validator
                ->integer('id')
                ->allowEmptyString('id', 'create');

            $validator
                ->scalar('keyconfig')
                ->maxLength('keyconfig', 255)
                ->requirePresence('keyconfig', 'create')
                ->allowEmptyString('keyconfig', FALSE);

            $validator
                ->scalar('label')
                ->allowEmptyString('label');

            return $validator;
        }
    }
