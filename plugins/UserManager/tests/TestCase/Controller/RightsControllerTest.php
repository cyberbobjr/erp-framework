<?php

    namespace UserManager\Test\TestCase\Controller;

    use Cake\TestSuite\IntegrationTestTrait;
    use Cake\TestSuite\TestCase;
    use UserManager\Model\Entity\Right;

    /**
     * UserManager\Controller\RightsController Test Case
     */
    class RightsControllerTest extends TestCase
    {
        use IntegrationTestTrait;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.UserManager.Rights'
        ];

        public function setUp()
        {
            $this->configRequest([
                'headers' => ['Accept' => 'application/json']
            ]);
            parent::setUp();
        }

        public function test_should_return_unauthorized()
        {
            $this->get('/user-manager/rights');
            $this->assertResponseCode(302);
        }

        public function test_should_return_ok_when_authenticated()
        {
            $this->session(['Auth' => ['User' => ['id']]]);
            $this->get('/user-manager/rights');
            $this->assertResponseOk();
            $rights = $this->_getBodyAsString();
            $expected = '{
    "rights": [
        {
            "id": 1,
            "code": "ADMIN",
            "label": "ADMIN"
        }
    ]
}';
            self::assertEquals($expected, $rights);
        }

        public function test_should_return_right_when_giving_id()
        {
            $this->session(['Auth' => ['User' => ['id']]]);
            $this->get('/user-manager/rights/view/1');
            $this->assertResponseOk();
            $rights = new Right(json_decode($this->_getBodyAsString(), TRUE)['right']);
            self::assertEquals('ADMIN', $rights->code);
            self::assertEquals('ADMIN', $rights->label);
        }
    }
