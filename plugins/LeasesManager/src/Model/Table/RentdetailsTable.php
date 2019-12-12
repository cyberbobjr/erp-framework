<?php

namespace LeasesManager\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Loyerdetails Model
 *
 * @property \App\Model\Table\RentsTable|\Cake\ORM\Association\BelongsTo $Loyers
 * @property |\Cake\ORM\Association\BelongsTo $TypeOperations
 * @property |\Cake\ORM\Association\BelongsTo $Tvas
 *
 * @method \App\Model\Entity\Rentdetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rentdetail newEntity($data = NULL, array $options = [])
 * @method \App\Model\Entity\Rentdetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rentdetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rentdetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rentdetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rentdetail findOrCreate($search, callable $callback = NULL, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RentdetailsTable extends Table
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

        $this->setTable('loyerdetails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Loyers', ['foreignKey' => 'loyer_id',
                                    'joinType'   => 'INNER']);
        $this->belongsTo('TypeOperations', ['foreignKey' => 'type_operation_id']);
        $this->belongsTo('Tvas', ['foreignKey' => 'tva_id',
                                  'joinType'   => 'INNER']);
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

        $validator->allowEmpty('libelle');

        $validator->decimal('montant_ttc')
                  ->allowEmpty('montant_ttc');

        $validator->decimal('montant_ht')
                  ->allowEmpty('montant_ht');

        $validator->decimal('montant_tva')
                  ->allowEmpty('montant_tva');

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
        $rules->add($rules->existsIn(['loyer_id'], 'Loyers'));
        $rules->add($rules->existsIn(['type_operation_id'], 'TypeOperations'));
        $rules->add($rules->existsIn(['tva_id'], 'Tvas'));

        return $rules;
    }
}
