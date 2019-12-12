<?php

    namespace OperationsManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * TypeOpsFixture
     */
    class TypeOpsFixture extends TestFixture
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
            'plugin'       => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'label'        => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'receipt'      => ['type'      => 'boolean',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => '0',
                               'comment'   => '',
                               'precision' => NULL],
            'chooseable'   => ['type'      => 'boolean',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => '0',
                               'comment'   => '',
                               'precision' => NULL],
            'created'      => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'comment'   => '',
                               'precision' => NULL],
            'modified'     => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'comment'   => '',
                               'precision' => NULL],
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
                    'id'         => 1,
                    'plugin'     => 'OperationsManager',
                    'label'      => 'test',
                    'receipt'    => 1,
                    'chooseable' => TRUE,
                    'created'    => '2019-05-03 22:45:05',
                    'modified'   => '2019-05-03 22:45:05'
                ],
                [
                    'id'         => 2,
                    'plugin'     => 'OperationsManager',
                    'label'      => 'test 2',
                    'receipt'    => 1,
                    'chooseable' => TRUE,
                    'created'    => '2019-05-03 22:45:05',
                    'modified'   => '2019-05-03 22:45:05'
                ],
            ];
            parent::init();
        }
    }
