<?php

    namespace  UserManager\Test\TestCase\Model\Table;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use UserManager\Model\Entity\Right;
    use UserManager\Model\Table\GroupesTable;
    use UserManager\Model\Table\RightsTable;
    use UserManager\Model\Table\UsersTable;

    /**
     * Class DroitsTableTest
     * @package UserManager\src\Model\Table
     * @property RightsTable $Rights
     * @property GroupesTable $Groupes
     * @property UsersTable $Users
     */
    class RightsTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var \UserManager\Model\Table\GroupesTable
         */
        public $Groupes;
        public $Users;
        public $GroupesUsers;
        public $Rights;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.UserManager.Groupes',
            'plugin.UserManager.GroupesUsers',
            'plugin.UserManager.Rights',
            'plugin.UserManager.RightsGroupes',
            'plugin.UserManager.Users',
        ];

        public function setUp()
        {
            parent::setUp();
            $this->Groupes = TableRegistry::getTableLocator()
                                          ->get('UserManager.Groupes');
            $this->Users = TableRegistry::getTableLocator()
                                        ->get('UserManager.Users');
            $this->Rights = TableRegistry::getTableLocator()
                                         ->get('UserManager.Rights');
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->Groupes);
            unset($this->Users);
            unset($this->Rights);

            parent::tearDown();
        }

        public function test_should_rights_must_be_checked_with_required_fields()
        {
            $rights = ['label' => 'TEST'];
            $rightsEntity = $this->Rights->newEntity($rights);
            self::assertFalse($this->Rights->save($rightsEntity));
        }

        public function test_should_not_create_duplicate_rights()
        {
            $rights = ['code'  => 'TEST',
                       'label' => 'TEST'];
            $rightsEntity = $this->Rights->newEntity($rights);
            self::assertInstanceOf(Right::class, $this->Rights->save($rightsEntity));
            $rightsEntity2 = $this->Rights->newEntity($rights);
            self::assertFalse($this->Rights->save($rightsEntity2));
        }
    }
