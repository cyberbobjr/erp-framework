<?php

    namespace LeasesManager\Test\TestCase;


    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;
    use LeasesManager\Plugin;
    use OperationsManager\Model\Table\TypeOpsTable;

    /**
     * Class LeasesPluginTest
     * @package LeasesManager\Test\TestCase
     * @property TypeOpsTable $TypeOps;
     * @property Plugin plugin
     */
    class LeasesPluginTest extends TestCase
    {
        private $TypeOps;
        private $plugin;

        public $fixtures = [
            'plugin.OperationsManager.TypeOps',
            'plugin.OperationsManager.Operations',
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
            $this->loadPlugins(['LeasesManager' => ['bootstrap' => TRUE]]);
            $this->TypeOps = TableRegistry::getTableLocator()
                                          ->get('OperationsManager.TypeOps');
            $this->plugin = new Plugin();
        }

        public function tearDown()
        {
            parent::tearDown();
            unset($this->plugin);
        }

        public function test_should_add_renttypeops()
        {
            $this->plugin->activate();
            self::assertEquals(1, $this->TypeOps->find()
                                                ->where(['plugin' => 'LeasesManager',
                                                         'label'  => __('Loyer')])
                                                ->count());
        }

        public function test_should_uninstall_renttypeops()
        {
            $this->plugin->activate();
            self::assertEquals(1, $this->TypeOps->find()
                                                ->where(['plugin' => 'LeasesManager',
                                                         'label'  => __('Loyer')])
                                                ->count());
            $this->plugin->deactivate();
            self::assertEquals(0, $this->TypeOps->find()
                                                ->where(['plugin' => 'LeasesManager',
                                                         'label'  => __('Loyer')])
                                                ->count());
        }

    }
