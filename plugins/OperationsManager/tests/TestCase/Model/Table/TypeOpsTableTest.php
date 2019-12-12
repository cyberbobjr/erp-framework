<?php

    namespace OperationsManager\Test\TestCase\Model\Table;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use OperationsManager\Model\Table\TypeOpsTable;

    /**
     * OperationsManager\Model\Table\TypeOpsTable Test Case
     */
    class TypeOpsTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var TypeOpsTable
         */
        public $TypeOps;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.OperationsManager.TypeOps',
            'plugin.OperationsManager.Operations'
        ];

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            $config = TableRegistry::getTableLocator()
                                   ->exists('TypeOps') ? [] : ['className' => TypeOpsTable::class];
            $this->TypeOps = TableRegistry::getTableLocator()
                                          ->get('TypeOps', $config);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->TypeOps);

            parent::tearDown();
        }

        public function test_should_not_save_empty_label()
        {
            $data = ['label'  => '',
                     'plugin' => 'OperationsManager'];
            $entity = $this->TypeOps->newEntity($data);
            self::assertFalse($this->TypeOps->save($entity));
        }

        /**
         * Test initialize method
         *
         * @return void
         */
        public function test_should_not_add_existing_typeops()
        {
            self::assertFalse($this->TypeOps->addTypeOps('OperationsManager', 'test'));
        }

        public function test_should_add_typeops()
        {
            self::assertNotFalse($this->TypeOps->addTypeOps('OperationsManager', 'test xx'));
        }

        public function test_should_remove_typeops()
        {
            $pluginName = 'OperationsManager';
            $label = 'test 2';
            self::assertNotFalse($this->TypeOps->deleteByPluginNameAndLabel($pluginName, $label));
            self::assertEquals(0, count($this->TypeOps->find()
                                                      ->where(['plugin' => $pluginName,
                                                               'label'  => $label])
                                                      ->toArray()));
        }

        public function test_should_not_remove_typeops_if_used()
        {
            $pluginName = 'OperationsManager';
            $label = 'test';
            self::assertFalse($this->TypeOps->deleteByPluginNameAndLabel($pluginName, $label));
        }

        public function test_should_get_used_typeops()
        {
            $pluginName = 'OperationsManager';
            $label = 'test';
            self::assertTrue($this->TypeOps->isUsed($pluginName, $label));
        }

        public function test_should_not_appear_if_not_chooseable()
        {
            $pluginname = 'OperationsManager';
            $label = 'test 3';
            $this->TypeOps->addTypeOps($pluginname, $label, FALSE);
            $list = $this->TypeOps->find('list')
                                  ->where(['label' => $label]);
            self::assertEquals(0, $list->count());
        }
    }
