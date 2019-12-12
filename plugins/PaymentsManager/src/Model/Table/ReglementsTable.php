<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Reglements Model
 *
 * @property \App\Model\Table\BanksTable|\Cake\ORM\Association\BelongsTo        $Banques
 * @property \App\Model\Table\TypePaymentsTable|\Cake\ORM\Association\BelongsTo  $TypePaiements
 * @property \App\Model\Table\OperationsTable|\Cake\ORM\Association\BelongsToMany $Operations
 *
 * @method \App\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payment newEntity($data = NULL, array $options = [])
 * @method \App\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payment findOrCreate($search, callable $callback = NULL, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReglementsTable extends Table
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

        $this->setTable('reglements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search');

        $this->belongsTo('Banques', ['foreignKey' => 'banque_id']);
        $this->belongsTo('TypePaiements', ['foreignKey' => 'type_paiement_id']);
        $this->belongsToMany('Operations', ['foreignKey'       => 'reglement_id',
                                            'targetForeignKey' => 'operation_id',
                                            'joinTable'        => 'operations_payments']);
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

        $validator->allowEmpty('numero');

        $validator->allowEmpty('commentaire');

        $validator->date('date', ['dmy'])
                  ->allowEmpty('date');

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
        $rules->add($rules->existsIn(['banque_id'], 'Banques'));
        $rules->add($rules->existsIn(['type_paiement_id'], 'TypePaiements'));

        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['operations'])) {
            foreach ($data['operations'] as $key => $operation) {
                if (isset($operation['_joinData']['montant']) && empty($operation['_joinData']['montant'])) {
                    unset($data['operations'][$key]);
                }
            }
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $operationsTable = TableRegistry::get('Operations');
        foreach ($entity->operations as $operation) {
            $operationsTable->updateSolde($operation->id);
        }
    }
}
