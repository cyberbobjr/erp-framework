<?php

    namespace  UserManager\Tests\TestCase\Model\Table;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use UserManager\Model\Table\GroupsTable;
    use UserManager\Model\Table\UsersTable;

    /**
     * Class UsersTableTest
     * @package UserManager\src\Model\Table
     * @property UsersTable $Users
     * @property GroupsTable $Groupes
     */
    class UsersTableTest extends TestCase
    {
        public $Groupes;
        public $Users;
        public $GroupesUsers;

        private $userData = ['username'         => 'test',
                             'firstname'        => 'Benjamin',
                             'lastname'         => 'Marchand',
                             'email'            => 'cyberbobrj@yahoo.com',
                             'password'         => 'azerty123456',
                             'password_confirm' => 'azerty123456'];

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
        }

        public function tearDown()
        {
            unset($this->Groupes);
            unset($this->Users);

            parent::tearDown();
        }

        public function test_should_not_create_user_without_required_fields()
        {
            $data = ['username' => 'bmarchand'];
            $user = $this->Users->newEntity($data);
            self::assertTrue($user->hasErrors());


            $user = $this->Users->newEntity($this->userData);
            self::assertFalse($user->hasErrors());
        }

        public function test_should_confirm_password_must_be_equal_to_password()
        {
            $user = $this->_createUser();
            $password = 'azerty123456';
            $password_confirm = 'azerty8910';
            self::assertFalse($this->Users->changePassword($user->id, $password, $password_confirm));
        }

        public function test_should_password_rules_must_be_respected()
        {
            $user = $this->_createUser();
            $password = 'azerty';
            $password_confirm = 'azerty';
            self::assertFalse($this->Users->changePassword($user->id, $password, $password_confirm));
        }

        public function test_should_not_find_archived_user()
        {
            $user = $this->_createUser();
            self::assertEquals(2, $this->Users->find()
                                              ->count());
            $this->Users->setArchive($user->id);

            self::assertEquals(1, $this->Users->find()
                                              ->count());
        }

        public function test_should_not_saved_duplicate_user()
        {
            $this->_createUser();
            self::assertFalse($this->_createUser());
        }

        public function test_should_update_user()
        {
            $user = $this->_createUser();
            $user->firstname = 'test';
            $user = $this->Users->patchEntity($user, ['firstname' => 'test']);
            self::assertCount(0, $user->getErrors());
            self::assertNotFalse($this->Users->save($user));
        }

        private function _createUser()
        {
            $user = $this->Users->newEntity($this->userData);
            return $this->Users->save($user);
        }
    }
