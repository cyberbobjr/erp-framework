<?php

    namespace App\Model\Table;

    use App\Application;
    use ArrayObject;
    use Cake\Core\App;
    use Cake\Core\PluginCollection;
    use Cake\Datasource\EntityInterface;
    use Cake\Event\Event;
    use Cake\ORM\Query;
    use Cake\ORM\RulesChecker;
    use Cake\ORM\Table;
    use Cake\Validation\Validator;
    use LeasesManager\Plugin;

    /**
     * AppPlugins Model
     *
     * @method \App\Model\Entity\AppPlugin get($primaryKey, $options = [])
     * @method \App\Model\Entity\AppPlugin newEntity($data = NULL, array $options = [])
     * @method \App\Model\Entity\AppPlugin[] newEntities(array $data, array $options = [])
     * @method \App\Model\Entity\AppPlugin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\AppPlugin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \App\Model\Entity\AppPlugin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \App\Model\Entity\AppPlugin[] patchEntities($entities, array $data, array $options = [])
     * @method \App\Model\Entity\AppPlugin findOrCreate($search, callable $callback = NULL, $options = [])
     *
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class AppPluginsTable extends Table
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

            $this->setTable('app_plugins');
            $this->setDisplayField('name');
            $this->setPrimaryKey('id');

            $this->addBehavior('Timestamp');
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

        public function afterSave(\Cake\Event\EventInterface $event, EntityInterface $entity, ArrayObject $options)
        {
            if ($entity->isDirty('activated')) {
                $pluginName = $entity->get('name');
                $pluginClassName = '\\' . $pluginName . '\\plugin';
                $plugin = new $pluginClassName();
                if ($entity->get('activated') === TRUE && method_exists($plugin, 'activate')) {
                    $plugin->activate();
                } elseif (method_exists($plugin, 'deactivate')) {
                    $plugin->deactivate();
                }
            }
        }
    }
