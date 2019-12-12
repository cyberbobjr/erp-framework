<?php


    namespace ExamplePlugin\Test;


    use Cake\TestSuite\TestCase;
    use ExamplePlugin\Plugin;

    /**
     * Class ExamplePluginTest
     * @package ExamplePlugin\Test\Core
     * @property Plugin $plugin
     */
    class ExamplePluginTest extends TestCase
    {

        private $plugin;
        private $extendFields = [
            'TiersManager\Model\Entity\Customer' => [
                'new_prop' => ['type'    => 'integer',
                               'options' => [
                                   'null' => TRUE]]
            ]];

        /**
         *
         */
        public function setUp()
        {
            $this->plugin = new Plugin();
            parent::setUp(); // TODO: Change the autogenerated stub
        }

        public function tearDown()
        {
            unset($this->plugin);
            parent::tearDown(); // TODO: Change the autogenerated stub
        }

        public function test_should_add_custom_fields_when_activate()
        {
            $this->plugin->setExtendFields($this->extendFields);
            self::assertTrue($this->plugin->activate());
        }

        public function test_should_remove_custom_fields_when_deacivate()
        {
            $this->plugin->setExtendFields($this->extendFields);
            self::assertTrue($this->plugin->deactivate());
        }
    }
