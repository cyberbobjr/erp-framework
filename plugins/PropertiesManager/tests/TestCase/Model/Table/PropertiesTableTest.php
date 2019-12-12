<?php

    namespace PropertiesManager\Tests\TestCase\Model\Table;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use PropertiesManager\Model\Table\PropertiesTable;
    use UserManager\Model\Table\UsersTable;

    /**
     * Class PropertiesTableTest
     * @package PropertiesManager\src\Model\Table
     * @property PropertiesTable $Properties
     * @property UsersTable $Users
     */
    class PropertiesTableTest extends TestCase
    {

        public $Properties;
        public $Users;

        public $fixtures = [
            'plugin.PropertiesManager.Properties',
            'plugin.UserManager.Users',
        ];

        public function setUp()
        {
            $this->Properties = TableRegistry::getTableLocator()
                                             ->get('PropertiesManager.Properties');
            $this->Users = TableRegistry::getTableLocator()
                                        ->get('UserManager.Users');
            parent::setUp();
        }

        public function tearDown()
        {
            unset($this->Properties);

            parent::tearDown();
        }

        public function test_should_not_save_if_required_fields_not_present()
        {
            $data = ['address1'  => 'Lorem ipsum dolor sit amet',
                     'address2'  => 'Lorem ipsum dolor sit amet',
                     'zipcode'   => 'Lorem ipsum dolor sit amet',
                     'city'      => 'Lorem ipsum dolor sit amet',
                     'lotnumber' => 1,
                     'floor'     => 1,
                     'numero'    => 'Lorem ips',
                     'building'  => 1,
                     'comments'  => ''];
            $property = $this->Properties->newEntity($data);
            self::assertTrue($property->hasErrors());
        }

        public function test_should_save_with_required_fields()
        {
            $data = ['designation' => 'test',
                     'address1'    => 'Lorem ipsum dolor sit amet',
                     'address2'    => 'Lorem ipsum dolor sit amet',
                     'zipcode'     => 'Lorem ipsum dolor sit amet',
                     'city'        => 'Lorem ipsum dolor sit amet',
                     'lotnumber'   => 1,
                     'floor'       => 1,
                     'numero'      => 'Lorem ips',
                     'building'    => 1,
                     'comments'    => ''];
            $property = $this->Properties->newEntity($data);
            self::assertFalse($property->hasErrors());
            self::assertNotFalse($this->Properties->save($property));
        }
    }
