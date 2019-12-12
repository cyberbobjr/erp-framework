<?php

    namespace OperationsManager\Model\Table;

    use App\Model\Entity\Vat;
    use Cake\Event\Event;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;
    use Cake\Validation\Validator;
    use OperationsManager\Model\Entity\Operationdetail;

    /**
     * Operationdetails Model
     *
     * @property OperationsTable|\Cake\ORM\Association\BelongsTo $Operations
     * @property \App\Model\Table\VatsTable|\Cake\ORM\Association\BelongsTo $Vats
     * @property |\Cake\ORM\Association\BelongsTo $TypeOperationdetails
     *
     * @method \OperationsManager\Model\Entity\Operationdetail get($primaryKey, $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail newEntity($data = NULL, array $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail[] newEntities(array $data, array $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail[] patchEntities($entities, array $data, array $options = [])
     * @method \OperationsManager\Model\Entity\Operationdetail findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class OperationdetailsTable extends Table
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

            $this->setTable('operationdetails');
            $this->setDisplayField('id');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');

            $this->belongsTo('Operations', [
                'foreignKey' => 'operation_id',
                'joinType'   => 'INNER',
                'className'  => 'OperationsManager.Operations'
            ]);
            $this->belongsTo('Vats', [
                'foreignKey' => 'vat_id',
                'joinType'   => 'INNER',
                'className'  => 'Vats'
            ]);
            $this->belongsTo('TypeOperationdetails', [
                'foreignKey' => 'type_operationdetail_id',
                'joinType'   => 'INNER',
                'className'  => 'OperationsManager.TypeOperationdetails'
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
                ->decimal('total_included_vat')
                ->allowEmptyString('total_included_vat');

            $validator
                ->decimal('total_without_vat')
                ->allowEmptyString('total_without_vat');

            $validator
                ->decimal('total_vat')
                ->allowEmptyString('total_vat');

            $validator
                ->decimal('vatrate')
                ->allowEmptyString('vatrate');

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
            $rules->add($rules->existsIn(['operation_id'], 'Operations'));
            $rules->add($rules->existsIn(['vat_id'], 'Vats'));
            $rules->add($rules->existsIn(['type_operationdetail_id'], 'TypeOperationdetails'));

            return $rules;
        }

        public function beforeSave(Event $event, Operationdetail $entity, $options)
        {
            $this->_calculateSumOperation($entity);
            return TRUE;
        }

        private function _calculateSumOperation(Operationdetail $entity)
        {
            $vatrate = 0;
            if (!is_null($entity->get('vat_id'))) {
                $vatTable = TableRegistry::getTableLocator()
                                         ->get('Vats');
                /** @var Vat $vat */
                $vat = $vatTable->get($entity->get('vat_id'));
                $vatrate = $vat->get('rate');
            }
            $entity->total_vat = $entity->total_without_vat / 100 * $vatrate;
            $entity->total_included_vat = $entity->total_vat + $entity->total_without_vat;
        }

    }
