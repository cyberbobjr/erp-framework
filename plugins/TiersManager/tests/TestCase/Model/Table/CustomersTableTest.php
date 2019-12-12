<?php

    namespace TiersManager\Test\TestCase\Model\Table;

    use App\Core\AppConstants;
    use Cake\Event\EventList;
    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use TiersManager\Model\Table\CustomersTable;

    /**
     * TiersManager\Model\Table\CustomersTable Test Case
     */
    class CustomersTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var CustomersTable
         */
        public $Customers;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.TiersManager.TypeTiers',
            'plugin.TiersManager.Tiers'
        ];

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            $this->Customers = TableRegistry::getTableLocator()
                                            ->get('TiersManager.Customers');
            $this->Customers->getEventManager()
                            ->setEventList(new EventList());
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Customers);

            parent::tearDown();
        }

        public function test_should_not_created_customer_with_existing_email()
        {
            $newCustomer = ['firstname' => 'Benjamin',
                            'lastname'  => 'Marchand',
                            'email'     => 'test@test.com'];
            $entity = $this->Customers->newEntity($newCustomer);
            $result = $this->Customers->save($entity);
            self::assertFalse($result);
            self::assertTrue($entity->hasErrors());
            self::assertArrayHasKey('email', $entity->getErrors());
        }

        public function test_should_not_create_customer_if_infos_fields_not_present()
        {
            $newCustomer = ['email' => 'test2@test.com'];
            $entity = $this->Customers->newEntity($newCustomer);
            $result = $this->Customers->save($entity);
            self::assertFalse($result);
            self::assertArrayHasKey('lastname', $entity->getErrors());
        }

        public function test_should_create_customer()
        {
            $newCustomer = ['firstname' => 'Benjamin',
                            'lastname'  => 'Marchand',
                            'email'     => NULL];
            $entity = $this->Customers->newEntity($newCustomer);
            $result = $this->Customers->save($entity);
            self::assertNotFalse($result);
            self::assertFalse($entity->hasErrors());
        }

        public function test_should_find_only_customer()
        {
            $customers = $this->Customers->find();
            foreach ($customers as $customer) {
                self::assertEquals(AppConstants::CUSTOMER, $customer->get('type_tier_id'));
            }
        }

        public function test_should_raise_event_before_save()
        {
            $newCustomer = ['firstname' => 'Benjamin',
                            'lastname'  => 'Marchand',
                            'email'     => NULL];
            $entity = $this->Customers->newEntity($newCustomer);
            $this->Customers->save($entity);
            $this->assertEventFired('Model.beforeSave', $this->Customers->getEventManager());
        }

        public function test_should_raise_event_after_save()
        {
            $newCustomer = ['firstname' => 'Benjamin',
                            'lastname'  => 'Marchand',
                            'email'     => NULL];
            $entity = $this->Customers->newEntity($newCustomer);
            $this->Customers->save($entity);
            $this->assertEventFired('Model.afterSave', $this->Customers->getEventManager());
        }
    }
