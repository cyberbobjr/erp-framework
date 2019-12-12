<?php

    namespace LeasesManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * RentsFixture
     */
    class RentsFixture extends TestFixture
    {
        /**
         * Fields
         *
         * @var array
         */
        // @codingStandardsIgnoreStart
        public $fields = [
            'id'                 => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => FALSE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'autoIncrement' => TRUE,
                                     'precision'     => NULL],
            'lease_id'           => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => FALSE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            'ref'                => ['type'      => 'boolean',
                                     'length'    => NULL,
                                     'null'      => FALSE,
                                     'default'   => '0',
                                     'comment'   => '',
                                     'precision' => NULL],
            'total_included_vat' => ['type'      => 'decimal',
                                     'length'    => 10,
                                     'precision' => 2,
                                     'unsigned'  => FALSE,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => ''],
            'total_without_vat'  => ['type'      => 'decimal',
                                     'length'    => 10,
                                     'precision' => 2,
                                     'unsigned'  => FALSE,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => ''],
            'total_vat'          => ['type'      => 'decimal',
                                     'length'    => 10,
                                     'precision' => 2,
                                     'unsigned'  => FALSE,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => ''],
            'vat_id'             => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => FALSE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            'vat'                => ['type'      => 'decimal',
                                     'length'    => 10,
                                     'precision' => 2,
                                     'unsigned'  => FALSE,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => ''],
            'start_period'       => ['type'      => 'date',
                                     'length'    => NULL,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => '',
                                     'precision' => NULL],
            'end_period'         => ['type'      => 'date',
                                     'length'    => NULL,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => '',
                                     'precision' => NULL],
            'comments'           => ['type'      => 'text',
                                     'length'    => NULL,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'collate'   => 'utf8_general_ci',
                                     'comment'   => '',
                                     'precision' => NULL],
            'created'            => ['type'      => 'datetime',
                                     'length'    => NULL,
                                     'null'      => FALSE,
                                     'default'   => NULL,
                                     'comment'   => '',
                                     'precision' => NULL],
            'modified'           => ['type'      => 'datetime',
                                     'length'    => NULL,
                                     'null'      => FALSE,
                                     'default'   => NULL,
                                     'comment'   => '',
                                     'precision' => NULL],
            '_indexes'           => [
                'lease_id' => ['type'    => 'index',
                               'columns' => ['lease_id'],
                               'length'  => []],
            ],
            '_constraints'       => [
                'primary'      => ['type'    => 'primary',
                                   'columns' => ['id'],
                                   'length'  => []],
                'rents_ibfk_1' => ['type'       => 'foreign',
                                   'columns'    => ['lease_id'],
                                   'references' => ['leases',
                                                    'id'],
                                   'update'     => 'restrict',
                                   'delete'     => 'restrict',
                                   'length'     => []],
            ],
            '_options'           => [
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
                    'id'                 => 1,
                    'lease_id'           => 1,
                    'ref'                => 1,
                    'total_included_vat' => 1.5,
                    'total_without_vat'  => 1.5,
                    'total_vat'          => 1.5,
                    'vat_id'             => 1,
                    'vat'                => 1.5,
                    'start_period'       => '2019-05-13',
                    'end_period'         => '2019-05-13',
                    'comments'           => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'created'            => '2019-05-13 19:09:23',
                    'modified'           => '2019-05-13 19:09:23'
                ],
            ];
            parent::init();
        }
    }
