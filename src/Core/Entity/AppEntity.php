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
    abstract class AppEntity extends \Cake\ORM\Entity
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
        public static function addNewField(string $field, array $fieldProperties): bool
        {
            try {
                $db = \Cake\Datasource\ConnectionManager::get('default');
                $config = $db->config();
                $config['user'] = $config['username'];
                $config['pass'] = $config['password'];
                $config['name'] = $config['database'];
                $migration = new \Migrations\AbstractMigration(NULL, 1);
                $migration->setAdapter(new \Phinx\Db\Adapter\MysqlAdapter($config, new \Symfony\Component\Console\Input\StringInput(' '), new \Symfony\Component\Console\Output\NullOutput()));
                $tableName = self::getClassName(get_called_class()) . '_extends';
                if (!$migration->hasTable($tableName)) {
                    $parentClass = self::getClassName(get_called_class());
                    $migration->table($tableName)->addForeignKey($parentClass . '_id', \Cake\Utility\Inflector::pluralize($parentClass), 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])->create();
                }
                $table = $migration->table($tableName);
                if (!$table->hasColumn($field)) {
                    $table = $table->addColumn($field, $fieldProperties['type'], $fieldProperties['options']);
                } else {
                    throw new \RuntimeException(__('Column {0} already exist in table {1}', $field, $tableName));
                }
                $table->update();
                return TRUE;
            } catch (\Exception $ex) {
                throw new \RuntimeException($ex->getMessage());
            }
        }
        public static function getClassName($calledClass)
        {
            $name = explode('\\', strtolower($calledClass));
            return $name[count($name) - 1];
        }
        public static function removeField(string $field): bool
        {
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $config = $db->config();
            $config['user'] = $config['username'];
            $config['pass'] = $config['password'];
            $config['name'] = $config['database'];
            $adapter = new \Phinx\Db\Adapter\MysqlAdapter($config, new \Symfony\Component\Console\Input\StringInput(' '), new \Symfony\Component\Console\Output\NullOutput());
            try {
                $adapter->beginTransaction();
                $tableName = self::getClassName(get_called_class()) . '_extends';
                if (!$adapter->hasColumn($tableName, $field)) {
                    throw new \RuntimeException(__('Column {0} not exist in table {1}', $field, $tableName));
                } else {
                    $adapter->dropColumn($tableName, $field);
                }
                $adapter->commitTransaction();
                return TRUE;
            } catch (\Exception $ex) {
                $adapter->rollbackTransaction();
                return FALSE;
            }
        }
        public function getFieldsType()
        {
            if (empty($this->_registryAlias)) {
                return [];
            }
            $table = \Cake\ORM\TableRegistry::getTableLocator()->get($this->_registryAlias);
            $schema = $table->getSchema();
            $results = [];
            foreach ($schema->columns() as $column) {
                if ($this->isAccessible($column) && $this->isFieldVisible($column)) {
                    $results[$column] = $table->getSchema()->getColumn($column);
                }
            }
            return $results;
        }
        public function getLabelForField(string $fieldName): string
        {
            return $this->_fieldControls[$fieldName]->getLabel() ?? $fieldName;
        }
        public function isFieldVisible(string $fieldName): bool
        {
            return $this->_fieldControls[$fieldName]->getVisible() ?? TRUE;
        }
        public function getFormType(string $fieldName)
        {
            return $this->_fieldControls[$fieldName]->getType();
        }
        public function getFieldControlOrder(string $fieldName)
        {
            return array_search($fieldName, array_keys($this->_fieldControls), TRUE);
        }
    }
