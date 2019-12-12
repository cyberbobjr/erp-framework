<?php

    namespace TiersManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * TypeTiersFixture
     */
    class TypeTiersFixture extends TestFixture
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
            'label'        => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'direction'    => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => TRUE,
                               'default'       => '0',
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'plan_id'      => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => TRUE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'created'      => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'comment'   => '',
                               'precision' => NULL],
            'modified'     => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => TRUE,
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
                    'id'        => 1,
                    'label'     => 'Customer',
                    'direction' => 1,
                    'plan_id'   => 1,
                    'created'   => '2019-05-06 11:43:42',
                    'modified'  => '2019-05-06 11:43:42'
                ], [
                    'id'        => 2,
                    'label'     => 'Supplier',
                    'direction' => 1,
                    'plan_id'   => 1,
                    'created'   => '2019-05-06 11:43:42',
                    'modified'  => '2019-05-06 11:43:42'
                ],
            ];
            parent::init();
        }
    }
