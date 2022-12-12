<?php

    namespace Wizardinstaller\Test\TestCase\libs;

    use Cake\Datasource\ConnectionManager;
    use Cake\ORM\TableRegistry;
    use Faker\Factory;
    use UserManager\Model\Entity\User;
    use UserManager\Model\Table\UsersTable;
    use Wizardinstaller\Exceptions\InstallException;
    use Wizardinstaller\libs\InstallService;
    use Cake\TestSuite\TestCase;

    class InstallServiceTest extends TestCase
    {
        private InstallService $installService;
        private $connection;

        protected function setUp(): void
        {
            parent::setUp();
            $this->connection = ConnectionManager::get('test');
            $this->connection->query("DROP DATABASE test_erp_dev");
            $this->connection->query("CREATE DATABASE test_erp_dev");
            $this->installService = new InstallService('test');
        }

        /**
         * @testdox When Given null values will raise an exception
         * @return void
         */
        public function testGivenNullDataShouldThrowException(): void
        {
            $this->expectException(InstallException::class);
            $this->expectExceptionMessage(__("Données vides, session expirée"));
            $this->installService->execute(NULL, NULL);
        }

        public function testGivenValidDataShouldCreateDB(): void
        {
            $faker = Factory::create();
            $bdd = [
                'notcreate' => FALSE
            ];
            $admin = [
                'username'  => $faker->userName,
                'password'  => $faker->password,
                'email'     => $faker->email,
                'lastname'  => $faker->lastName,
                'firstname' => $faker->firstName
            ];
            $results = $this->installService->execute($admin, $bdd);
            $this->assertTrue(count($results) > 0);

            // check for admin user & rights
            /** @var UsersTable $usersTable */
            $usersTable = TableRegistry::getTableLocator()->get('UserManager.Users');
            $users = $usersTable->find()->contain(['Groups', 'Groups.Rights']);
            $this->assertEquals(1, $users->count());
            /** @var User $user */
            $user = $users->first();
            $this->assertEquals($admin['username'], $user->username);
            $this->assertEquals($admin['email'], $user->email);
            $this->assertEquals(strtoupper($admin['lastname']), $user->lastname);
            $this->assertEquals($admin['firstname'], $user->firstname);
            $this->assertEquals(1, count($user->groups));
            $this->assertEquals('ADMIN', $user->groups[0]->label);
            /**
             * Check for existing tables
             * Expected tables :
             *  configs
             *  rights
             *  rights_groups
             *  groups_users
             *  events
             *  groups
             *  languages
             *  countries
             *  vats
             *  type_events
             */
            $expectedTables = [
                'configs',
                'rights',
                'rights_groups',
                'groups_users',
                'events',
                'groups',
                'languages',
                'countries',
                'vats',
                'type_events'
            ];
            foreach ($expectedTables as $expectedTable) {
                $this->assertTrue($this->connection->query("DESCRIBE `$expectedTable`")->execute());
            }
        }
    }
