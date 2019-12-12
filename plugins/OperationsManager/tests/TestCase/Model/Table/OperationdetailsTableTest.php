<?php

    namespace OperationsManager\Test\TestCase\Model\Table;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use OperationsManager\Model\Table\OperationdetailsTable;

    /**
     * OperationsManager\Model\Table\OperationdetailsTable Test Case
     */
    class OperationdetailsTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var \OperationsManager\Model\Table\OperationdetailsTable
         */
        public $Operationdetails;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.OperationsManager.Operationdetails',
            'plugin.OperationsManager.Operations',
            'plugin.OperationsManager.Typeoperationdetails',
            'app.Vats'
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
                                   ->exists('Operationdetails') ? [] : ['className' => OperationdetailsTable::class];
            $this->Operationdetails = TableRegistry::getTableLocator()
                                                   ->get('Operationdetails', $config);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Operationdetails);

            parent::tearDown();
        }

        public function test_should_save_compute_detail_sum()
        {
            $operationDetail = [
                [
                    'operation_id'            => 1,
                    'label'                   => 'TEST 1',
                    'total_without_vat'       => '100',
                    'vat_id'                  => 1,
                    'vatrate'                 => '20',
                    'type_operationdetail_id' => 1
                ],
                [
                    'operation_id'            => 1,
                    'label'                   => 'TEST 2',
                    'total_without_vat'       => '100',
                    'vat_id'                  => 1,
                    'vatrate'                 => '20',
                    'type_operationdetail_id' => 1
                ]
            ];
            $entities = $this->Operationdetails->newEntities($operationDetail);
            foreach ($entities as $entity) {
                $result = $this->Operationdetails->save($entity);
                self::assertNotFalse($result);
            }

            $details = $this->Operationdetails->find('all');
            foreach ($details as $detail) {
                $expectedTotalIncludedVat = $detail->get('total_without_vat') + ($detail->get('total_without_vat') / 100 * $detail->get('vatrate'));
                self::assertEquals($detail->get('total_included_vat'), $expectedTotalIncludedVat);
            }
        }
    }
