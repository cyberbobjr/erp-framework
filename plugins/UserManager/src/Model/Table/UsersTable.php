<?php

    namespace UserManager\Model\Table;

    use Cake\Datasource\ConnectionManager;
    use Cake\Event\Event;
    use Cake\ORM\Query;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * Users Model
     *
     * @property \Cake\ORM\Association\HasMany $Mesures
     * @property \Cake\ORM\Association\HasMany $Rapports
     * @property GroupesTable|\Cake\ORM\Association\BelongsToMany $Groupes
     * @property Table|\Cake\ORM\Association\HasMany $GroupesUsers
     * @method \UserManager\Model\Entity\User get($primaryKey, $options = [])
     * @method \UserManager\Model\Entity\User newEntity($data = NULL, array $options = [])
     * @method \UserManager\Model\Entity\User[] newEntities(array $data, array $options = [])
     * @method \UserManager\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \UserManager\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \UserManager\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \UserManager\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
     * @method \UserManager\Model\Entity\User findOrCreate($search, callable $callback = NULL, $options = [])
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     * @mixin \Geo\Model\Behavior\GeocoderBehavior
     * @mixin \Josegonzalez\Upload\Model\Behavior\UploadBehavior
     */
    class UsersTable extends Table
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
            $this->setDisplayField('fullname');
            $this->addBehavior('Timestamp');
            $this->addBehavior('Geo.Geocoder', ['locale'  => 'FR',
                                                'address' => ['address',
                                                              'zipcode',
                                                              'city']]);
            $this->addBehavior('Josegonzalez/Upload.Upload',
                ['profile' => ['pathProcessor'         => 'UserManager\Model\Table\Base64Processor',
                               'writer'                => 'UserManager\Model\Table\Base64Writer',
                               'keepFilesOnDelete'     => TRUE,
                               'restoreValueOnFailure' => TRUE,
                               'fields'                => ['dir' => 'image_dir']]]);

            $this->belongsToMany('UserManager.Groupes', ['foreignKey'       => 'users_id',
                                                         'targetForeignKey' => 'groupes_id',
                                                         'joinTable'        => 'groupes_users']);
        }

        /**
         * Default validation rules.
         *
         * @param  \Cake\Validation\Validator  $validator  Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator->add('id', 'valid', ['rule' => 'numeric'])
                      ->isEmptyAllowed('id', TRUE);

            $validator->requirePresence('username', 'create')
                      ->isEmptyAllowed('username', FALSE);

            $validator->requirePresence('lastname', 'create')
                      ->isEmptyAllowed('lastname', FALSE);

            $validator->requirePresence('firstname', 'create')
                      ->isEmptyAllowed('firstname', FALSE);

            $validator->requirePresence('email', 'create')
                      ->isEmptyAllowed('email', FALSE);

            $validator->add('username', 'custom', ['rule'     => 'isUnique',
                                                   'provider' => 'table',
                                                   'message'  => __('Ce compte utilisateur est déjà utilisé')]);
            $validator->add('email', 'custom', ['rule'     => 'isUnique',
                                                'provider' => 'table',
                                                'message'  => __('Cet email utilisateur est déjà utilisé')]);

            return $this->validationPassword($validator);
        }

        /**
         * Fonction de validation d'un mot de passe
         * Vérifie que le mot de passe est bien présent dans le cas d'un register manuel
         * Vérifie la taille du mot de passe
         * Vérifie que le mot de passe confirmé est identique au mot de passe saisi
         * @param  Validator  $validator
         * @return Validator
         */
        public function validationPassword(Validator $validator)
        {

            return $validator->requirePresence('password', function ($context) {
                if ($context['newRecord']) {
                    return !(isset($context['data']['social_type']) && !empty($context['data']['social_type']));
                }
                return FALSE;
            }, __('Le mot de passe est requis'))
                             ->requirePresence('password_confirm',
                                 function ($context) {
                                     return !empty($context['data']['password']);
                                 }, __('Vous devez saisir le mot de passe de confirmation (confirmation).'))
                             ->add('password_confirm', 'equalToPassword', ['on'      => function ($context) {
                                 return !empty($context['data']['password']);
                             },
                                                                           'rule'    => function ($value, $context) {
                                                                               return ($value === $context['data']['password']);
                                                                           },
                                                                           'message' => __('Le mot de passe de confirmation doit être identique au mot de passe saisi.')])
                             ->add('password', 'lengthBetween', ['on'      => function ($context) {
                                 return !empty($context['data']['password']);
                             },
                                                                 'rule'    => ['lengthBetween',
                                                                               8,
                                                                               20],
                                                                 'message' => __('La longueur du mot de passe doit être entre {0} et {1} caractères',
                                                                     8, 20)]);
        }

        /**
         * Fonction de validation d'un champ unique
         * Cette fonction a l'avantage de ne pas utiliser les query de l'ORM et donc de ne pas déclencher les events beforeXXXX
         * @param $check
         * @param $context
         * @return bool
         */
        public function isUnique($check, $context)
        {
            $connection = ConnectionManager::get('default');
            if (!empty($context['data']['id'])) {
                $id = $context['data']['id'];
                $results = $connection->execute('SELECT * FROM users WHERE '.$context['field'].' = :checkvalue AND archive!=TRUE AND id != :checkid',
                    ['checkvalue' => $check,
                     'checkid'    => $id])
                                      ->fetchAll('assoc');
            } else {
                $results = $connection->execute('SELECT * FROM users WHERE '.$context['field'].' = :checkvalue AND archive!=TRUE',
                    ['checkvalue' => $check])
                                      ->fetchAll('assoc');
            }
            return (count($results) == 0);
        }

        /**
         * Formattage des noms/prenoms avant sauvegarde
         * @param $event
         * @param $entity
         * @param $options
         */
        public function beforeSave($event, $entity, $options)
        {
            $entity->lastname = strtoupper($entity->lastname);
            $entity->city = strtoupper($entity->city);
            $entity->firstname = ucwords($entity->firstname);
            if ($entity->lastname && $entity->firstname) {
                $entity->fullname = $entity->firstname.' '.$entity->lastname;
            }
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
            return $rules;
        }

        /**
         * Place la date de dernière connexion pour un utilisateur
         * @param  int  $user_id  Référence de l'utilisateur
         * @param  string  $last_login  Date de dernière connexion
         * @return mixed Entité mise à jour ou FALSE en cas d'erreur
         */
        public function setLastLogin($user_id, $last_login)
        {
            if ($user_id === NULL) {
                return FALSE;
            }
            $user = $this->get($user_id);
            $user->last_login = $last_login;
            return $this->save($user);
        }

        /**
         * Créé une clef de réinitialisation de mot de passe pour un utilisateur donné
         * @param  string  $courriel  Courriel de l'utilisateur
         * @return bool|\Cake\Datasource\EntityInterface|mixed
         */
        public function setResetKey($courriel = NULL)
        {
            if (is_null($courriel)) {
                return FALSE;
            }
            $account = $this->find('all', ['bypassAuth' => TRUE])
                            ->where(['courriel' => $courriel])
                            ->first();
            $account->uuid = md5(date('d-m-Y H:i:s'));
            return $this->save($account);
        }

        /**
         * Fonction qui vérifie qu'une clef de reset password correspond bien à l'id spécifié en paramètre
         * @param  string  $resetkey  Clef de réinitialisation
         * @param  int  $id  Référence du compte que nous voulons vérifier
         * @return bool TRUE si le compte correspond, FALSE sinon
         */
        public function checkResetKey($resetkey, $id)
        {
            $account = $this->get($id);
            return ($account->uuid == $resetkey);
        }

        /**
         * Supprime l'uuid (ou resetkey) du compte participant
         * @param  int  $id  Référence du participant sur lequel nous voulons supprimer la clef
         * @return bool|\Cake\Datasource\EntityInterface|mixed
         */
        public function removeResetKey($id)
        {
            $account = $this->get($id);
            $account->uuid = NULL;
            return $this->save($account);
        }

        /**
         * Sauve le jeton d'accès passé en paramètre pour l'utilisateur
         * @param  int  $user_id  Référence de l'utilisateur
         * @param  array  $accessToken  Jeton d'accès à sauvegarder
         * @return bool|\Cake\Datasource\EntityInterface|mixed
         */
        public function setAccessToken($user_id, $accessToken)
        {
            $account = $this->get($user_id);
            $account->access_token = json_encode($accessToken);
            return $this->save($account);
        }

        /**
         * Retourne le jeton d'accès de l'utilisateur spécifié en paramètre
         * @param  int  $user_id  Référence de l'utilisateur
         * @return mixed Jeton d'accès
         */
        public function getAccessToken($user_id)
        {
            $account = $this->get($user_id);
            return json_decode($account->access_token, TRUE);
        }

        /**
         * Change le statut active d'un utilisateur
         * @param $user_id
         * @param $active
         * @return bool|\Cake\Datasource\EntityInterface|mixed
         */
        public function setActive($user_id, $active)
        {
            $user = $this->get($user_id);
            $user->active = $active;
            return $this->save($user);
        }

        /**
         * @param $data
         * @return bool|\Cake\Datasource\EntityInterface|\Cake\ORM\Entity|mixed
         */
        public function register($data)
        {
            $user = $this->newEntity($data, ['associated' => ['Groupes',
                                                              'Groupes.Rights']]);
            $this->save($user);
            return $user;
        }

        /**
         * Modifie la query avant le find pour s'assurer que l'utilisateur a bien les droits
         * @param  Event  $event
         * @param  Query  $query
         * @param  \ArrayObject  $options
         * @param              $primary
         */
        public function beforeFind(Event $event, Query $query, \ArrayObject $options, $primary)
        {
            $query->andWhere([$this->_alias.'.archive' => FALSE]);
        }

        /**
         * Fonction finder utilisée pour les mécanismes d'authentification, permet de bypasser le mécanisme multiclient
         * @param  Query  $query
         * @param  array  $options
         * @return Query
         */
        public function findAuth(Query $query, array $options)
        {
            $query->find('all', ['bypassAuth' => TRUE])
                  ->where(['archive' => FALSE]);
            return $query;
        }

        /**
         * Place l'IP de connexion dans le modèle utilisateur
         * @param  int  $user_id  Référence de l'utilisateur
         * @param  string  $ip  Adresse IP de l'utilisateur
         * @return mixed Entité mise à jour ou FALSE en cas d'erreur
         */
        public function setIp($user_id = NULL, $ip)
        {
            if (is_null($user_id)) {
                return FALSE;
            }
            $user = $this->get($user_id);
            $user->ip = $ip;
            return $this->save($user);
        }

        /**
         * Archive un utilisateur
         * @param      $user_id
         * @param  bool  $archive
         * @return bool|\Cake\Datasource\EntityInterface|mixed
         */
        public function setArchive($user_id, $archive = TRUE)
        {
            $user = $this->get($user_id);
            $user->archive = $archive;
            return $this->save($user);
        }

        public function changePassword(int $userId, string $password, string $password_confirm)
        {
            $user = $this->get($userId);
            $user = $this->patchEntity($user, ['password'         => $password,
                                               'password_confirm' => $password_confirm]);
            return $this->save($user);
        }

    }
