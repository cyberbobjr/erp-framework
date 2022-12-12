<?php

    namespace UserManager\Test\TestCase\Controller;

    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\IntegrationTestTrait;
    use Cake\TestSuite\TestCase;
    use UserManager\Model\Entity\Group;

    class GroupesControllerTest extends TestCase
    {
        use IntegrationTestTrait;

        public $fixtures = [
            'plugin.UserManager.Rights',
            'plugin.UserManager.Groupes',
            'plugin.UserManager.RightsGroupes',
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

        public function test_admin_group_should_not_be_deleted()
        {
            $this->delete('/user-manager/groupes/delete/1');
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Ce groupe ne peut pas être supprimé.', 'flash');
        }

        public function test_group_should_be_deleted()
        {
            $groupesTable = TableRegistry::getTableLocator()
                                         ->get('UserManager.Groupes');
            $groupe = $groupesTable->newEntity(['label'       => 'TEST',
                                                'description' => 'description']);
            $groupe = $groupesTable->save($groupe);
            $this->delete('/user-manager/groupes/delete/' . $groupe->id);
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Le groupe a été supprimé.', 'flash');
        }

        public function test_should_display_list_groups()
        {
            $this->get('/user-manager/groupes/index');
            $this->assertResponseOk();
            $this->assertContains('ADMIN', $this->_getBodyAsString());
        }

        public function test_should_display_view_group()
        {
            $this->get('/user-manager/groupes/view/1');
            $this->assertResponseOk();
            $this->assertInstanceOf(Group::class, $this->viewVariable('groupe'));
            $this->assertContains('ADMIN', $this->_getBodyAsString());
        }

        public function test_should_add_new_group()
        {
            $group = ['label'       => 'newGroup',
                      'description' => 'test description'];
            $this->post('/user-manager/groupes/add', $group);
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Le groupe a été enregistré.', 'flash');
        }

        public function test_should_edit_groupe()
        {
            $groupData = ['label'       => 'TEST',
                          'description' => 'description'];
            $groupesTable = TableRegistry::getTableLocator()
                                         ->get('UserManager.Groupes');
            $groupe = $groupesTable->newEntity($groupData);
            $groupe = $groupesTable->save($groupe);

            $groupData['label'] = 'newTEST';
            $this->post('/user-manager/groupes/add/' . $groupe->id, $groupData);
            $this->assertResponseCode(302);
            $this->assertFlashMessage('Le groupe a été enregistré.', 'flash');
        }
    }
