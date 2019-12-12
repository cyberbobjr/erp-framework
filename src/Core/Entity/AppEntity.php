<?php

    namespace App\Core\Entity;

    use Cake\Datasource\ConnectionManager;
    use Cake\ORM\Entity;
    use Cake\ORM\TableRegistry;
    use Cake\Utility\Inflector;
    use Exception;
    use Migrations\AbstractMigration;
    use Phinx\Db\Adapter\MysqlAdapter;
    use RuntimeException;
    use Symfony\Component\Console\Input\StringInput;
    use Symfony\Component\Console\Output\NullOutput;

    abstract class AppEntity extends Entity
    {
        /**
         * @var FieldDescriptor[] $_fieldControls
         */
        protected $_fieldControls = [];

        /**
         * @param  String  $field
         * @param  array  $fieldProperties  Properties for the new field, check Phinx Migration doc
         * @return bool
         * @throws Exception
         */
        public static function addNewField(String $field, array $fieldProperties): bool
        {
            try {
                $db = ConnectionManager::get('default');
                $config = $db->config();
                $config['user'] = $config['username'];
                $config['pass'] = $config['password'];
                $config['name'] = $config['database'];
                $migration = new AbstractMigration(NULL, 1);
                $migration->setAdapter(new MysqlAdapter($config, new StringInput(' '), new NullOutput()));
                $tableName = self::getClassName(get_called_class()).'_extends';
                if (!$migration->hasTable($tableName)) {
                    $parentClass = self::getClassName(get_called_class());
                    $migration->table($tableName)
                              ->addForeignKey($parentClass.'_id', Inflector::pluralize($parentClass), 'id', ['delete' => 'NO_ACTION',
                                                                                                             'update' => 'NO_ACTION'])
                              ->create();
                }
                $table = $migration->table($tableName);
                if (!$table->hasColumn($field)) {
                    $table = $table->addColumn($field, $fieldProperties['type'], $fieldProperties['options']);
                } else {
                    throw new RuntimeException(__('Column {0} already exist in table {1}', $field, $tableName));
                }
                $table->update();

                return TRUE;
            } catch (Exception $ex) {
                throw new RuntimeException($ex->getMessage());
            }
        }

        public static function getClassName($calledClass)
        {
            $name = explode('\\', strtolower($calledClass));
            return $name[count($name) - 1];
        }

        public static function removeField(String $field): bool
        {
            $db = ConnectionManager::get('default');
            $config = $db->config();
            $config['user'] = $config['username'];
            $config['pass'] = $config['password'];
            $config['name'] = $config['database'];
            $adapter = new MysqlAdapter($config, new StringInput(' '), new NullOutput());
            try {
                $adapter->beginTransaction();
                $tableName = self::getClassName(get_called_class()).'_extends';
                if (!$adapter->hasColumn($tableName, $field)) {
                    throw new RuntimeException(__('Column {0} not exist in table {1}', $field, $tableName));
                } else {
                    $adapter->dropColumn($tableName, $field);
                }
                $adapter->commitTransaction();
                return TRUE;
            } catch (Exception $ex) {
                $adapter->rollbackTransaction();
                return FALSE;
            }
        }

        public function getFieldsType()
        {
            if (empty($this->_registryAlias)) {
                return [];
            }
            $table = TableRegistry::getTableLocator()
                                  ->get($this->_registryAlias);
            $schema = $table->getSchema();
            $results = [];
            foreach ($schema->columns() as $column) {
                if ($this->isAccessible($column) && $this->isFieldVisible($column)) {
                    $results[$column] = $table->getSchema()
                                              ->getColumn($column);
                }
            }
            return $results;
        }

        public function getLabelForField(String $fieldName): String
        {
            return $this->_fieldControls[$fieldName]->getLabel() ?? $fieldName;
        }

        public function isFieldVisible(String $fieldName): bool
        {
            return $this->_fieldControls[$fieldName]->getVisible() ?? TRUE;
        }

        public function getFormType(String $fieldName)
        {
            return $this->_fieldControls[$fieldName]->getType();
        }

        public function getFieldControlOrder(String $fieldName)
        {
            return array_search($fieldName, array_keys($this->_fieldControls), TRUE);
        }
    }
