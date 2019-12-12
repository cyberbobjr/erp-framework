<?php

    namespace TiersManager\Test\TestCase\Controller;

    use Cake\TestSuite\IntegrationTestTrait;
    use Cake\TestSuite\TestCase;

    /**
     * TiersManager\Controller\CustomersController Test Case
     */
    class CustomersControllerTest extends TestCase
    {
        use IntegrationTestTrait;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.TiersManager.TypeTiers',
            'plugin.TiersManager.Tiers',
            'plugin.AppPluginsManager.AppPlugins'
        ];

        public function testIndex()
        {
            $this->get('/tiers-manager/customers/index');
            $this->assertResponseSuccess();
        }

        public function testAdd()
        {
            $data = ['firstname' => 'ben',
                     'email'     => 'ben.marchand@free.fr'];
            $this->session(['Auth.User.id' => 1]);
            $this->post('/tiers-manager/customers/add', $data);
            $this->assertResponseSuccess();
        }
    }
