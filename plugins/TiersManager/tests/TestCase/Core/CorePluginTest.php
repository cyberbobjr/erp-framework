<?php


    namespace TiersManager\Test\TestCase\Core;


    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use TiersManager\Model\Entity\Customer;
    use TiersManager\Model\Table\CustomerExtendsTable;
    use TiersManager\Model\Table\CustomersTable;

    /**
     * Class CorePluginTest
     * @property CustomersTable $customersTable
     * @package TiersManager\Test\TestCase\Core
     * @property CustomerExtendsTable $customerExtendsTable
     * @property Customer $CustomerExtend
     */
    class CorePluginTest extends TestCase
    {
        private $fields = [
            'new_prop' => [
                'type'    => 'integer',
                'options' => [
                    'null'  => TRUE,
                    'limit' => 11
                ]
            ]
        ];
        public $fixtures = [
            'plugin.TiersManager.TypeTiers',
            'plugin.TiersManager.Tiers',
            'plugin.TiersManager.CustomerExtends'
        ];

        public function setUp()
        {
            parent::setUp();
            $this->CustomerExtend = new Customer();

            $this->customersTable = TableRegistry::getTableLocator()
                                                 ->get('TiersManager.Customers');
            $this->customerExtendsTable = TableRegistry::getTableLocator()
                                                       ->get('TiersManager.CustomerExtends');
        }

        public function tearDown()
        {
            parent::tearDown();
            foreach ($this->fields as $fieldName => $fieldProps) {
                Customer::removeField($fieldName);
            }
        }

        public function test_should_add_custom_fields_to_customer()
        {
            foreach ($this->fields as $fieldName => $fieldProps) {
                $result = Customer::addNewField($fieldName, $fieldProps);
                self::assertTrue($result);
            }
        }

        /**
         *
         */
        public function test_should_save_custom_fields_when_add_customer()
        {
            foreach ($this->fields as $fieldName => $fieldProps) {
                Customer::addNewField($fieldName, $fieldProps);
            }
            $new_prop = 1;
            $data = [
                'email'            => 'test2@test.com',
                'firstname'        => 'Benjamin',
                'lastname'         => 'Marchand',
                'customer_extends' => [
                    ['new_prop' => $new_prop]
                ]
            ];
            $entity = $this->customersTable->newEntity($data);
            self::assertArrayHasKey('customer_extends', $entity->toArray());
            $result = $this->customersTable->save($entity);
            self::assertNotFalse($result);

            $entity = $this->customersTable->get($result->id, ['contain' => ['CustomerExtends']]);
            self::assertEquals($new_prop, $entity->customer_extends[0]['new_prop']);
        }
    }
