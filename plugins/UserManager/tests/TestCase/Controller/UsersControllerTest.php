<?php

    namespace UserManager\Test\TestCase\Controller;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\IntegrationTestTrait;
    use Cake\TestSuite\TestCase;
    use UserManager\Model\Table\UsersTable;

    class UsersControllerTest extends TestCase
    {
        use IntegrationTestTrait;

        public $fixtures = [
            'plugin.UserManager.Rights',
            'plugin.UserManager.Groupes',
            'plugin.UserManager.Users',
        ];

        public function setUp()
        {
            $this->enableRetainFlashMessages();
            $this->useHttpServer(TRUE);
            $this->session([
                'rights' => ['ADMIN'],
                'Auth'   => ['User' => ['id' => 1]]]);
            parent::setUp();
        }

        public function tearDown()
        {
            parent::tearDown(); // TODO: Change the autogenerated stub
        }

        public function test_should_add_user()
        {
            $userData = ['username'         => 'test',
                         'firstname'        => 'Benjamin',
                         'lastname'         => 'MARCHAND',
                         'email'            => 'test@test.com',
                         'password'         => 'azerty1234',
                         'password_confirm' => 'azerty1234'];
            $this->post('/user-manager/users/add', $userData);
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Utilisateur créé avec succès !', 'flash');
        }

        public function testToken()
        {

        }

        public function test_should_edit_user()
        {
            $this->get('/user-manager/users/edit/1');
            $this->assertResponseOk();

            $modifiedData = ['firstname' => 'TEST',
                             'lastname'  => 'test'];
            $this->post('/user-manager/users/edit/1', $modifiedData);
            $this->assertResponseOk();
            $this->assertFlashMessage('Utilisateur mis à jour', 'flash');

            $usersTable = TableRegistry::getTableLocator()
                                       ->get('UserManager.Users');
            $user = $usersTable->get(1);
            self::assertNotFalse($user);
            self::assertEquals($modifiedData['firstname'], $user['firstname']);
        }

        public function test_should_be_deleted()
        {
            $this->delete('/user-manager/users/delete/1');
            $this->assertFlashMessage('L\'utilisateur avec l\'id 1 a été supprimé.', 'flash');
        }

        public function test_user_should_login()
        {
            /** @var UsersTable $usersTable */
            $loginData = ['username' => 'bmarchand',
                          'password' => 'azerty12345'];
            $usersTable = TableRegistry::getTableLocator()
                                       ->get('UserManager.Users');
            $usersTable->changePassword(1, $loginData['password'], $loginData['password']);
            $this->post('/user-manager/users/login', $loginData);
            $this->assertResponseCode(302);
        }

        public function test_user_should_logout()
        {
            $this->get('/user-manager/users/logout');
            $this->assertFlashMessage('Vous êtes bien déconnecté', 'flash');
            $this->assertResponseCode(302);
        }

        public function test_should_display_users_list()
        {
            $this->get('/user-manager/users/index');
            $this->assertResponseOk();
            $this->assertContains('bmarchand', $this->_getBodyAsString());
        }

        public function test_should_display_first_login()
        {
            $this->get('/user-manager/users/first-login');
            $this->assertResponseOk();

            $password = ['password'         => 'azerty12345',
                         'password_confirm' => 'azerty12345'];
            $this->post('/user-manager/users/first-login', $password);
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Votre mot de passe a bien été modifié', 'flash');
        }

        public function test_should_display_error_if_password_is_bad_when_first_login()
        {
            $password = ['password'         => 'azerty12345',
                         'password_confirm' => 'azerty123459'];
            $this->post('/user-manager/users/first-login', $password);
            $this->assertResponseOk();
            $this->assertContains('Le mot de passe de confirmation doit être identique au mot de passe saisi', $this->_getBodyAsString());
        }

        public function test_login_should_display_error_if_password_is_wrong()
        {
            $loginData = ['username' => 'bmarchand',
                          'password' => 'azerty12345'];
            $this->post('/user-manager/users/login', $loginData);
            $this->assertFlashMessage('Login ou mot de passe incorrect.', 'flash');
        }

        public function test_should_display_user_detail()
        {
            $this->get('/user-manager/users/view/1');
            $this->assertResponseOk();
            $this->assertContains('Benjamin MARCHAND', $this->_getBodyAsString());
        }

        public function test_should_not_reset_password_when_unknown_email()
        {
            $data = ['email' => 'test@ben.com'];
            $this->post('/user-manager/users/lost-password', $data);
            $this->assertFlashMessage('Ce courriel n\'est pas référencé dans notre base en tant qu\'utilisateur', 'flash');
        }

        public function test_should_reset_password_with_good_uuid()
        {
            $uuid = '12334567890';
            $password = ['password'         => 'azerty12345',
                         'password_confirm' => 'azerty12345'];
            /** @var UsersTable $usersTable */
            $usersTable = TableRegistry::getTableLocator()
                                       ->get('UserManager.Users');
            $user = $usersTable->get(1);
            $user->uuid = $uuid;
            $usersTable->save($user);

            $this->post('/user-manager/users/reset-password/' . $uuid, $password);
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Votre mot de passe a été réinitialisé', 'flash');
        }

    }
