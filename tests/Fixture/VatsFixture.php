<?php

    namespace App\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * VatsFixture
     */
    class VatsFixture extends TestFixture
    {
        /**
         * Fields
         *
         * @var array
         */
        // @codingStandardsIgnoreStart
        public $fields = [
            'id'           => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => FALSE,
                               'default'       => NULL,
                               'comment'       => '',
                               'autoIncrement' => TRUE,
                               'precision'     => NULL],
            'rate'         => ['type'      => 'decimal',
                               'length'    => 5,
                               'precision' => 2,
                               'unsigned'  => FALSE,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'comment'   => ''],
            '_constraints' => [
                'primary' => ['type'    => 'primary',
                              'columns' => ['id'],
                              'length'  => []],
            ],
            '_options'     => [
                'engine'    => 'InnoDB',
                'collation' => 'utf8_general_ci'
            ],
        ];
        // @codingStandardsIgnoreEnd

        /**
         * Init method
         *
         * @return void
         */
        public function init()
        {
            $this->records = [
                [
                    'id'   => 1,
                    'rate' => 20
                ],
            ];
            parent::init();
        }
    }
