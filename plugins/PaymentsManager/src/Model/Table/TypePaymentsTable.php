<?php

namespace PaymentsManager\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypePaiements Model
 *
 * @property |\Cake\ORM\Association\HasMany $Reglements
 *
 * @method \App\Model\Entity\TypePayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypePayment newEntity($data = NULL, array $options = [])
 * @method \App\Model\Entity\TypePayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypePayment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypePayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypePayment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypePayment findOrCreate($search, callable $callback = NULL, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TypePaymentsTable extends Table
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

        $this->setTable('type_paiements');
        $this->setDisplayField('libelle');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Reglements', ['foreignKey' => 'type_paiement_id']);
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
