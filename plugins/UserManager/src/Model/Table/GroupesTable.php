<?php

    namespace UserManager\Model\Table;

    use Cake\Event\Event;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;
    use UserManager\Model\Entity\Groupe;
    use UserManager\Model\Entity\User;

    /**
     * Groupes Model
     *
     * @property Table|\Cake\ORM\Association\BelongsToMany $Rights
     * @property \UserManager\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
     *
     * @method \UserManager\Model\Entity\Groupe get($primaryKey, $options = [])
     * @method \UserManager\Model\Entity\Groupe newEntity($data = NULL, array $options = [])
     * @method \UserManager\Model\Entity\Groupe[] newEntities(array $data, array $options = [])
     * @method \UserManager\Model\Entity\Groupe|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \UserManager\Model\Entity\Groupe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \UserManager\Model\Entity\Groupe[] patchEntities($entities, array $data, array $options = [])
     * @method \UserManager\Model\Entity\Groupe findOrCreate($search, callable $callback = NULL, $options = [])
     * @property Table|\Cake\ORM\Association\HasMany $DroitsGroupes
     * @property Table|\Cake\ORM\Association\HasMany $GroupesUsers
     * @method \UserManager\Model\Entity\Groupe saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method findByLabel($groupeLabel)
     */
    class GroupesTable extends Table
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

            $this->setDisplayField('description');
            $this->belongsToMany('Rights', ['foreignKey'       => 'groupes_id',
                                            'className'        => 'UserManager.Rights',
                                            'targetForeignKey' => 'rights_id',
                                            'joinTable'        => 'rights_groupes']);
            $this->belongsToMany('UserManager.Users', ['foreignKey'       => 'groupes_id',
                                                       'targetForeignKey' => 'users_id',
                                                       'joinTable'        => 'groupes_users']);
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
                      ->isEmptyAllowed('id', TRUE);

            $validator->requirePresence('label');

            $validator->isEmptyAllowed('description', TRUE);

            $validator->add('users', 'custom', ['on'      => 'update',
                                                'rule'    => function ($value, $context) {
                                                    if (count($value['_ids']) == 0 && $context['data']['label'] == 'ADMIN') {
                                                        return FALSE;
                                                    }
                                                    return TRUE;
                                                },
                                                'message' => __('Il doit toujours y avoir un utilisateur dans ce groupe')]);
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
            $rules->add(function (Groupe $entity, $options) {
                if (!$entity->isNew() && $entity->getOriginal('label') == 'ADMIN') {
                    return !($entity->isDirty('label'));
                }
                return TRUE;
            }, 'custom', ['errorField' => 'label',
                          'message'    => 'Le label ne peut pas être modifié pour le groupe ADMIN']);
            return $rules;
        }

        /**
         * Vérification pour empecher de supprimer le groupe ADMIN
         * @param Event $event
         * @param \UserManager\Model\Entity\Groupe $entity
         * @param \ArrayObject $options
         * @return bool
         */
        public function beforeDelete(Event $event, Groupe $entity, \ArrayObject $options)
        {
            return !($entity->label == 'ADMIN');
        }

        public function addUserToGroup(User $user, $groupeLabel)
        {
            if (empty($user->id)) {
                return FALSE;
            }

            $userGroup = $this->findByLabel($groupeLabel)
                              ->first();
            if (!$userGroup) {
                throw new \Exception(__('Group {0} not exist', $groupeLabel));
            }
            return $this->Users->link($userGroup, [$user]);
        }
    }
