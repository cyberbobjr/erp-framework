<?php

    namespace App\Test\TestCase\Core;

    use App\Model\Entity\Vat;
    use App\Model\Table\VatsTable;
    use Cake\ORM\TableRegistry;
    use Cake\TestSuite\TestCase;

    /**
     * Class AppEntityTest
     * @package App\Test\TestCase\Core
     * @property VatsTable $vatsTable
     */
    class AppEntityTest extends TestCase
    {

        private $entityTest;
        private $vatsTable;

        public $fixtures = [
            'app.Vats'
        ];

        /**
         * setUp method
         *
         * @return void
         */
        public function setUp()
        {
            parent::setUp();
            $this->entityTest = new Vat();
            $this->vatsTable = TableRegistry::getTableLocator()
                                            ->get('Vats');
        }

        /**
         * tearDown method
         *
         * @return void
         */
        public function tearDown()
        {
            parent::tearDown();
        }

        public function test_should_get_data_from_table()
        {
            $vats = $this->vatsTable->find('all');
            self::assertEquals(count($vats->toArray()), 1);
        }

        public function test_should_return_all_columns()
        {
            $vatfields = $this->vatsTable->getSchema();
            self::assertArraySubset([
                'id',
                'rate'
            ], $vatfields->columns());
        }

        public function test_should_return_all_columns_properties()
        {
            /** @var Vat $vat */
            $vat = $this->vatsTable->get(1);
            self::assertArrayHasKey('rate', $vat);
        }
    }
