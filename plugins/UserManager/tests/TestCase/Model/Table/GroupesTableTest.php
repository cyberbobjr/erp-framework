<?php

    namespace UserManager\Test\TestCase\Model\Table;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use UserManager\Model\Entity\User;
    use UserManager\Model\Table\GroupesTable;
    use UserManager\Model\Table\UsersTable;

    /**
     * Class GroupesTableTest
     * @package UserManager\Test\TestCase\Model\Table
     * @property UsersTable $Users
     * @property GroupesTable $Groupes
     */
    class GroupesTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var GroupesTable
         */
        public $Groupes;
        public $Users;
        public $GroupesUsers;

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

            parent::tearDown();
        }

        public function test_should_add_user_to_admin_group()
        {
            $user = new User([
                'username' => 'benjamin',
                'fullname' => 'Benjamin Marchand',
                'password' => 'testtesttest',
                'email'    => 'testtesttest@ben.com'
            ]);
            $user = $this->Users->save($user);
            $result = $this->Groupes->addUserToGroup($user, 'ADMIN');
            self::assertNotFalse($result);

            $userLoaded = $this->Users->findById($user->id)
                                      ->contain(['Groupes'])
                                      ->first();
            self::assertCount(1, array_filter($userLoaded->groupes, function ($k) {
                return $k->label == 'ADMIN';
            }));
        }

        public function test_should_not_add_user_to_nonexistent_group()
        {
            $user = new User([
                'username' => 'benjamin',
                'fullname' => 'Benjamin Marchand',
                'password' => 'testtesttest',
                'email'    => 'testtesttest@ben.com'
            ]);
            $user = $this->Users->save($user);
            try {
                $this->Groupes->addUserToGroup($user, 'TEST');
                self::assertFalse(TRUE);
            } catch (\Exception $exception) {
                self::assertInstanceOf(\Exception::class, $exception);
            }
        }

        public function test_should_not_delete_admin_group()
        {
            $adminGroup = $this->Groupes->findByLabel('ADMIN')
                                        ->first();
            $result = $this->Groupes->delete($adminGroup);
            self::assertFalse($result);
        }

        public function test_should_not_modify_label_for_admin_group()
        {
            $adminGroup = $this->Groupes->findByLabel('ADMIN')
                                        ->first();
            $adminGroup->label = 'TEST';
            self::assertFalse($this->Groupes->save($adminGroup));
        }

        public function test_should_not_create_group_if_label_empty()
        {
            $groupe = $this->Groupes->newEntity(['description' => 'test description']);
            self::assertTrue($groupe->hasErrors());
        }
    }
