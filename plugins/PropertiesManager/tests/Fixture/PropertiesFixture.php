<?php

    namespace PropertiesManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * PropertiesFixture
     */
    class PropertiesFixture extends TestFixture
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
            'designation'  => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => '',
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'address1'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'address2'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'zipcode'      => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'city'         => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'lotnumber'    => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => TRUE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'floor'        => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => TRUE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'numero'       => ['type'      => 'string',
                               'length'    => 11,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'building'     => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => TRUE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'comments'     => ['type'      => 'text',
                               'length'    => NULL,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL],
            'created'      => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => 'CURRENT_TIMESTAMP',
                               'comment'   => '',
                               'precision' => NULL],
            'modified'     => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => 'CURRENT_TIMESTAMP',
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
                    'id'          => 1,
                    'designation' => 'Lorem ipsum dolor sit amet',
                    'address1'    => 'Lorem ipsum dolor sit amet',
                    'address2'    => 'Lorem ipsum dolor sit amet',
                    'zipcode'     => 'Lorem ipsum dolor sit amet',
                    'city'        => 'Lorem ipsum dolor sit amet',
                    'lotnumber'   => 1,
                    'floor'       => 1,
                    'numero'      => 'Lorem ips',
                    'building'    => 1,
                    'comments'    => '',
                    'created'     => '2019-04-28 09:22:23',
                    'modified'    => '2019-04-28 09:22:23'
                ],
            ];
            parent::init();
        }
    }
