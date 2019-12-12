<?php

    namespace AppPluginsManager\Test\TestCase\Model\Table;

    use AppPluginsManager\Model\Table\AppPluginsTable;
    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;

    /**
     * AppPluginsManager\Model\Table\AppPluginsTable Test Case
     */
    class AppPluginsTableTest extends TestCase
    {
        /**
         * Test subject
         *
         * @var \AppPluginsManager\Model\Table\AppPluginsTable
         */
        public $AppPlugins;

        /**
         * Fixtures
         *
         * @var array
         */
        public $fixtures = [
            'plugin.AppPluginsManager.AppPlugins'
        ];

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            $config = TableRegistry::getTableLocator()
                                   ->exists('AppPlugins') ? [] : ['className' => AppPluginsTable::class];
            $this->AppPlugins = TableRegistry::getTableLocator()
                                             ->get('AppPlugins', $config);
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            unset($this->AppPlugins);

            parent::tearDown();
        }

        /**
         * Test initialize method
         *
         * @return void
         */
        public function test_should_activate_plugin()
        {
            $result = $this->AppPlugins->activate(1);
            self::assertNotFalse($result);
        }

        public function test_should_deactivate_plugin()
        {
            $result = $this->AppPlugins->deactivate(1);
            self::assertNotFalse($result);
        }
    }
