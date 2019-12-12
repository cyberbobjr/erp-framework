<?php

    namespace OperationsManager\Test\TestCase\Model\Table;

    use Cake\Event\EventList;
    use Cake\Event\EventManager;
    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use OperationsManager\Model\Table\OperationsTable;
    use OperationsManager\State\OpenState;
    use OperationsManager\State\OpsStateEnum;
    use OperationsManager\Test\Factory\OpsFactory;
    use OperationsManager\Test\TypeOpsEnum;

    /**
     * OperationsManager\Model\Table\OperationsTable Test Case
     * @property OperationsTable $Operations
     */
    class OperationsTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var OperationsTable
         */
        public $Operations;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.UserManager.Users',
            'plugin.OperationsManager.Operations',
            'plugin.OperationsManager.TypeStates',
            'plugin.OperationsManager.TypeOps',
            'plugin.OperationsManager.Operationdetails',
            'plugin.OperationsManager.TypeOperationdetails',
            'plugin.OperationsManager.Payments',
            'plugin.OperationsManager.Tiers',
            'plugin.OperationsManager.Companies',
            'plugin.OperationsManager.Leases',
            'app.Vats',
        ];

        public $newOpData = ['tier_id'    => 1,
                             'company_id' => 1,
                             'label'      => 'Label operations',
                             'type_op_id' => TypeOpsEnum::OP_CUSTOMER_RENT,
                             'due_date'   => '2020-01-31'];
        public $newOpDetailData = [['label'                   => 'Sous-operation 1',
                                    'total_included_vat'      => 120,
                                    'total_without_vat'       => 100,
                                    'total_vat'               => 20,
                                    'vat_id'                  => 1,
                                    'vatrate'                 => 20.0,
                                    'type_operationdetail_id' => 1],
                                   ['label'                   => 'Sous-operation 2',
                                    'total_included_vat'      => 240,
                                    'total_without_vat'       => 200,
                                    'total_vat'               => 40,
                                    'vat_id'                  => 1,
                                    'vatrate'                 => 20.0,
                                    'type_operationdetail_id' => 1]
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
                                   ->exists('Operations') ? [] : ['className' => OperationsTable::class];
            $this->Operations = TableRegistry::getTableLocator()
                                             ->get('Operations', $config);
            EventManager::instance()
                        ->setEventList(new EventList());
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Operations);

            parent::tearDown();
        }

        public function test_should_not_create_operation_without_required_fields()
        {
            unset($this->newOpData['label']);
            $result = $this->Operations->createNewOp($this->newOpData);
            self::assertTrue($result->hasErrors());
            self::assertArrayHasKey('_required', $result->getError('label'));
        }

        /** @noinspection PhpUndefinedClassInspection */
        /** @noinspection PhpUndefinedNamespaceInspection */
        /**
         * @expectedException     OperationsManager\Exceptions\OperationsException
         * @ExpectedExceptionMessage 'Une opération ne peut pas revenir en mode brouillon'
         */
        public function test_should_not_create_operation_with_existing_state()
        {
            $this->newOpData['state'] = OpsStateEnum::$STATE_DRAFT;
            $this->Operations->createNewOp($this->newOpData);
            self::assertTrue(FALSE);
        }

        public function test_should_create_operation_with_required_field()
        {
            $result = $this->Operations->createNewOp($this->newOpData);
            self::assertFalse($result->hasErrors());
            self::assertNotNull($result->get('id'));
        }

        public function test_should_event_be_raised_before_save()
        {
            $this->Operations->createNewOp($this->newOpData);
            $this->assertEventFired('Model.beforeSave', EventManager::instance());
        }

        public function test_should_create_ops_with_details()
        {
            $data = OpsFactory::createOps($this->newOpData, TypeOpsEnum::OP_CUSTOMER_RENT);
            $operation = $this->Operations->createNewOp($data);

            $operationSaved = $this->Operations->get($operation->id);
            $data = array_merge($operationSaved->toArray(), ['operationdetails' => $this->newOpDetailData]);
            $operationSaved = $this->Operations->saveFullOps($operationSaved->id, $data);
            self::assertFalse($operationSaved->hasErrors());
            self::assertArrayHasKey('operationdetails', $operationSaved->toArray());
            self::assertCount(count($this->newOpDetailData), $operationSaved->get('operationdetails'));
        }

        public function test_should_create_ops_with_details_and_sum_calculated()
        {
            $data = OpsFactory::createOps($this->newOpData, TypeOpsEnum::OP_CUSTOMER_RENT);
            $operation = $this->Operations->createNewOp($data);

            $allData = array_merge($data, ['operationdetails' => $this->newOpDetailData]);
            $operationSaved = $this->Operations->saveFullOps($operation->id, $allData);
            $total = 0;
            foreach ($this->newOpDetailData as $opDetailDatum) {
                $total += $opDetailDatum['total_included_vat'];
            }
            self::assertEquals($total, $operationSaved->get('total_included_vat'));
            self::assertEquals(0, $operationSaved->get('balance'));
        }

        public function test_should_return_operations_unpaid()
        {
            $existing_operation = 1;
            $operation = $this->Operations->get($existing_operation);
            $operation = OpenState::setNewState($operation);
            $operation->set('balance', 0);
            $this->Operations->save($operation);
            $operationsUnpaid = $this->Operations->find('unpaid');
            self::assertEquals(0, $operationsUnpaid->count());

            $operation = $this->Operations->get($existing_operation);
            $operation = OpenState::setNewState($operation);
            $operation->set('balance', 1000);
            $this->Operations->save($operation);
            $operationsUnpaid = $this->Operations->find('unpaid');
            self::assertEquals(1, $operationsUnpaid->count());
        }

        public function shoud_raise_event_when_operation_created()
        {
            $this->Operations->createNewOp($this->newOpData);
            $this->assertEventFired('Model.Operations.created', EventManager::instance());

        }

        public function shoud_raise_event_when_operation_modified()
        {
            $this->Operations->createNewOp($this->newOpData);
            $this->assertEventFired('Model.Operations.modified', EventManager::instance());

        }
    }
