<?php

    namespace UserManager\Model\Table;

    use ArrayObject;
    use Cake\Datasource\EntityInterface;
    use Cake\Event\Event;
    use Cake\ORM\Association\BelongsToMany;
    use Cake\ORM\Association\HasMany;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;
    use Exception;
    use UserManager\Model\Entity\Group;
    use UserManager\Model\Entity\User;

    /**
     * Groups Model
     *
     * @property Table|BelongsToMany $Rights
     * @property UsersTable|BelongsToMany $Users
     *
     * @method Group get($primaryKey, $options = [])
     * @method Group newEntity($data = NULL, array $options = [])
     * @method Group[] newEntities(array $data, array $options = [])
     * @method Group|bool save(EntityInterface $entity, $options = [])
     * @method Group patchEntity(EntityInterface $entity, array $data, array $options = [])
     * @method Group[] patchEntities($entities, array $data, array $options = [])
     * @method Group findOrCreate($search, callable $callback = NULL, $options = [])
     * @property Table|HasMany $DroitsGroups
     * @property Table|HasMany $GroupsUsers
     * @method Group saveOrFail(EntityInterface $entity, $options = [])
     * @method findByLabel($groupLabel)
     */
    class GroupsTable extends Table
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

            $this->setDisplayField('description');
            $this->belongsToMany('Rights', ['foreignKey'       => 'groups_id',
                                            'className'        => 'UserManager.Rights',
                                            'targetForeignKey' => 'rights_id',
                                            'joinTable'        => 'rights_groups']);
            $this->belongsToMany('Users', ['foreignKey'       => 'groups_id',
                                           'targetForeignKey' => 'users_id',
                                           'className'        => 'UserManager.Users',
                                           'joinTable'        => 'groups_users']);
        }

        /**
         * Default validation rules.
         *
         * @param Validator $validator Validator instance.
         * @return Validator
         */
        public function validationDefault(Validator $validator): Validator
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
         * @param RulesChecker $rules The rules object to be modified.
         * @return RulesChecker
         */
        public function buildRules(RulesChecker $rules): RulesChecker
        {
            $rules->add(function (Group $entity, $options) {
                if (!$entity->isNew() && $entity->getOriginal('label') == 'ADMIN') {
                    return !($entity->isDirty('label'));
                }
                return TRUE;
            }, 'custom', ['errorField' => 'label',
                          'message'    => 'Le label ne peut pas être modifié pour le groupe ADMIN']);
            return $rules;
        }

        /**
         * Check to prevent deletion of group ADMIN
         * @param Event $event
         * @param Group $entity
         * @param ArrayObject $options
         * @return bool
         */
        public function beforeDelete(Event $event, Group $entity, ArrayObject $options)
        {
            return !($entity->label == 'ADMIN');
        }

        public function addUserToGroup(User $user, $groupLabel)
        {
            if (empty($user->id)) {
                return FALSE;
            }

            $userGroup = $this->findByLabel($groupLabel)
                              ->first();
            if (!$userGroup) {
                throw new Exception(__('Group {0} not exist', $groupLabel));
            }
            return $this->Users->link($userGroup, [$user]);
        }
    }
