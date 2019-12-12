<?php

    namespace AppPluginsManager\Model\Table;

    use App\Core\AppBasePlugin;
    use ArrayObject;
    use Cake\Datasource\EntityInterface;
    use Cake\Event\Event;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;

    /**
     * AppPlugins Model
     *
     * @method \AppPluginsManager\Model\Entity\AppPlugin get($primaryKey, $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin newEntity($data = NULL, array $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin[] newEntities(array $data, array $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin[] patchEntities($entities, array $data, array $options = [])
     * @method \AppPluginsManager\Model\Entity\AppPlugin findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class AppPluginsTable extends Table
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

            $this->setTable('app_plugins');
            $this->setDisplayField('name');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');
        }

        /**
         * Default validation rules.
         *
         * @param  Validator  $validator  Validator instance.
         * @return Validator
         */
        public function validationDefault(Validator $validator)
        {
            $validator
                ->integer('id')
                ->allowEmptyString('id', 'create');

            $validator
                ->scalar('name')
                ->maxLength('name', 255)
                ->requirePresence('name', 'create')
                ->allowEmptyString('name', FALSE);

            $validator
                ->boolean('activated')
                ->requirePresence('activated', 'create')
                ->allowEmptyString('activated', FALSE);

            return $validator;
        }

        public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
        {
            $className = $entity->get('name').'\Plugin';
            $this->setPluginState($className, $entity->get('activated'));
        }

        private function setPluginState($className, bool $state)
        {
            /** @var AppBasePlugin $newPlugin */
            $newPlugin = new $className;
            $state == TRUE ? $newPlugin->activate() : $newPlugin->deactivate();
        }

        public function activate(int $appplugin_id)
        {
            return $this->setActivated($appplugin_id, TRUE);
        }

        public function deactivate(int $appplugin_id)
        {
            return $this->setActivated($appplugin_id, FALSE);
        }

        private function setActivated($applugin_id, bool $state)
        {
            $appPlugin = $this->get($applugin_id);
            $appPlugin->activated = $state;
            return $this->save($appPlugin);
        }
    }
