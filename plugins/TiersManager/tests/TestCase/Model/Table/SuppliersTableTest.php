<?php

    namespace TiersManager\Test\TestCase\Model\Table;

    use App\Core\AppConstants;
    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use TiersManager\Model\Table\SuppliersTable;

    /**
     * TiersManager\Model\Table\SuppliersTable Test Case
     */
    class SuppliersTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var \TiersManager\Model\Table\SuppliersTable
         */
        public $Suppliers;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.TiersManager.Tiers',
            'plugin.TiersManager.TypeTiers'
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
                                   ->exists('Suppliers') ? [] : ['className' => SuppliersTable::class];
            $this->Suppliers = TableRegistry::getTableLocator()
                                            ->get('Suppliers', $config);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Suppliers);

            parent::tearDown();
        }

        public function test_should_not_created_customer_with_existing_email()
        {
            $newCustomer = ['firstname' => 'Benjamin',
                            'lastname'  => 'Marchand',
                            'email'     => 'test@test.com'];
            $entity = $this->Suppliers->newEntity($newCustomer);
            $result = $this->Suppliers->save($entity);
            self::assertFalse($result);
            self::assertTrue($entity->hasErrors());
            self::assertArrayHasKey('email', $entity->getErrors());
        }

        public function test_should_create_customer()
        {
            $newSupplier = ['firstname' => 'Benjamin',
                            'lastname'  => 'Marchand',
                            'email'     => NULL];
            $entity = $this->Suppliers->newEntity($newSupplier);
            $result = $this->Suppliers->save($entity);
            self::assertNotFalse($result);
            self::assertFalse($entity->hasErrors());
        }

        public function test_should_find_only_customer()
        {
            $customers = $this->Suppliers->find('all');
            foreach ($customers as $customer) {
                self::assertEquals(AppConstants::SUPPLIER, $customer->get('type_tier_id'));
            }
        }
    }
