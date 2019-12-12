<?php

    namespace LeasesManager\Model\Table;

    use ArrayObject;
    use Cake\Datasource\EntityInterface;
    use Cake\Event\Event;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * Bails Model
     *
     * @property \App\Model\Table\CompaniesTable|\Cake\ORM\Association\BelongsTo $Societes
     * @property |\Cake\ORM\Association\BelongsTo $Tvas
     * @property \App\Model\Table\PropertiesTable|\Cake\ORM\Association\hasOne $Biens
     * @property |\Cake\ORM\Association\BelongsTo $Tiers
     * @property \App\Model\Table\TypePeriodicitesTable|\Cake\ORM\Association\BelongsTo $TypePeriodicites
     * @property \App\Model\Table\RentsTable|\Cake\ORM\Association\hasOne $Loyers
     * @property |\Cake\ORM\Association\BelongsTo $Indices
     * @property |\Cake\ORM\Association\HasMany $Documentstiers
     * @property \App\Model\Table\OperationsTable|\Cake\ORM\Association\HasMany $Operations
     *
     * @method \App\Model\Entity\Lease get($primaryKey, $options = [])
     * @method \App\Model\Entity\Lease newEntity($data = NULL, array $options = [])
     * @method \App\Model\Entity\Lease[] newEntities(array $data, array $options = [])
     * @method \App\Model\Entity\Lease|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\Lease patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \App\Model\Entity\Lease[] patchEntities($entities, array $data, array $options = [])
     * @method \App\Model\Entity\Lease findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class LeasesTable extends Table
    {

        /**
         * Initialize method
         *
         * @param  array  $config  The configuration for the Table.
         * @return void
         */
        public function initialize(array $config)
        {
            $this->setTable('leases');
            $this->setDisplayField('designation');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');

            $this->belongsTo('CompaniesManager.Companies', ['foreignKey' => 'societe_id',
                                                            'joinType'   => 'INNER']);
            $this->belongsTo('Tvas', ['foreignKey' => 'tva_id']);
            $this->belongsTo('PropertiesManager.Properties', ['foreignKey' => 'bien_id',
                                                              'joinType'   => 'INNER']);
            $this->belongsTo('TiersManager.Customers', ['foreignKey' => 'tier_id',
                                                        'joinType'   => 'INNER']);
            $this->belongsTo('TypePeriodicites', ['foreignKey' => 'type_periodicite_id']);
            $this->hasOne('RentsManager.Rents', ['foreignKey' => 'bail_id']);

            $this->hasMany('Documentstiers', ['foreignKey' => 'bail_id']);
            $this->hasMany('OperationsManager.Operations', ['foreignKey' => 'bail_id']);
        }

        /**
         * Default validation rules.
         *
         * @param  \Cake\Validation\Validator  $validator  Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator->integer('id')
                      ->allowEmpty('id', 'create');

            $validator->requirePresence('designation', 'create')
                      ->notEmpty('designation');

            $validator->date('date_debut', ['dmy'])
                      ->allowEmpty('date_debut');

            $validator->date('date_fin', ['dmy'])
                      ->allowEmpty('date_fin');

            $validator->boolean('planif')
                      ->requirePresence('planif', 'create')
                      ->notEmpty('planif');

            $validator->decimal('valeur_indice')
                      ->allowEmpty('valeur_indice');

            $validator->allowEmpty('commentaire');

            $validator->boolean('actif')
                      ->requirePresence('actif', 'create')
                      ->notEmpty('actif');

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
            $rules->add($rules->existsIn(['societe_id'], 'Societes'));
            $rules->add($rules->existsIn(['tva_id'], 'Tvas'));
            $rules->add($rules->existsIn(['bien_id'], 'Biens'));
            $rules->add($rules->existsIn(['tier_id'], 'Clients'));
            $rules->add($rules->existsIn(['type_periodicite_id'], 'TypePeriodicites'));
            $rules->add($rules->existsIn(['loyer_id'], 'Loyers'));

            return $rules;
        }

        public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
        {
            if ($entity->isNew()) {
                $previousBails = $this->find()
                                      ->where(['id !='   => $entity->id,
                                               'bien_id' => $entity->bien_id,
                                               'actif'   => TRUE]);
                foreach ($previousBails as $previousBail) {
                    $previousBail->actif = FALSE;
                    $this->save($previousBail);
                }
            }
        }
    }
