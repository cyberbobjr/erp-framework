<?php

    namespace OperationsManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * OperationsFixture
     */
    class OperationsFixture extends TestFixture
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
                                     'null'          => TRUE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            'company_id'         => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => TRUE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            'tier_id'            => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => FALSE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            'type_op_id'         => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => FALSE,
                                     'default'       => NULL,
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            'label'              => ['type'      => 'string',
                                     'length'    => 255,
                                     'null'      => FALSE,
                                     'default'   => NULL,
                                     'collate'   => 'utf8_general_ci',
                                     'comment'   => '',
                                     'precision' => NULL,
                                     'fixed'     => NULL],
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
            'vatrate'            => ['type'      => 'boolean',
                                     'length'    => NULL,
                                     'null'      => FALSE,
                                     'default'   => '1',
                                     'comment'   => '',
                                     'precision' => NULL],
            'due_date'           => ['type'      => 'date',
                                     'length'    => NULL,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => '',
                                     'precision' => NULL],
            'draft'              => ['type'      => 'boolean',
                                     'length'    => NULL,
                                     'null'      => FALSE,
                                     'default'   => '0',
                                     'comment'   => '',
                                     'precision' => NULL],
            'commentspublic'     => ['type'      => 'text',
                                     'length'    => NULL,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'collate'   => 'utf8_general_ci',
                                     'comment'   => '',
                                     'precision' => NULL],
            'commentsprivate'    => ['type'      => 'text',
                                     'length'    => NULL,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'collate'   => 'utf8_general_ci',
                                     'comment'   => '',
                                     'precision' => NULL],
            'accounted'          => ['type'      => 'boolean',
                                     'length'    => NULL,
                                     'null'      => FALSE,
                                     'default'   => '0',
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
            'balance'            => ['type'      => 'float',
                                     'length'    => NULL,
                                     'precision' => NULL,
                                     'unsigned'  => FALSE,
                                     'null'      => TRUE,
                                     'default'   => NULL,
                                     'comment'   => ''],
            'state'              => ['type'          => 'integer',
                                     'length'        => 11,
                                     'unsigned'      => FALSE,
                                     'null'          => TRUE,
                                     'default'       => '1',
                                     'comment'       => '',
                                     'precision'     => NULL,
                                     'autoIncrement' => NULL],
            '_indexes'           => [
                'lease_id'   => ['type'    => 'index',
                                 'columns' => ['lease_id'],
                                 'length'  => []],
                'company_id' => ['type'    => 'index',
                                 'columns' => ['company_id'],
                                 'length'  => []],
                'tier_id'    => ['type'    => 'index',
                                 'columns' => ['tier_id'],
                                 'length'  => []],
                'type_op_id' => ['type'    => 'index',
                                 'columns' => ['type_op_id'],
                                 'length'  => []],
            ],
            '_constraints'       => [
                'primary'           => ['type'    => 'primary',
                                        'columns' => ['id'],
                                        'length'  => []],
                'operations_ibfk_1' => ['type'       => 'foreign',
                                        'columns'    => ['lease_id'],
                                        'references' => ['leases',
                                                         'id'],
                                        'update'     => 'restrict',
                                        'delete'     => 'restrict',
                                        'length'     => []],
                'operations_ibfk_2' => ['type'       => 'foreign',
                                        'columns'    => ['company_id'],
                                        'references' => ['companies',
                                                         'id'],
                                        'update'     => 'restrict',
                                        'delete'     => 'restrict',
                                        'length'     => []],
                'operations_ibfk_3' => ['type'       => 'foreign',
                                        'columns'    => ['tier_id'],
                                        'references' => ['tiers',
                                                         'id'],
                                        'update'     => 'restrict',
                                        'delete'     => 'restrict',
                                        'length'     => []],
                'operations_ibfk_5' => ['type'       => 'foreign',
                                        'columns'    => ['type_op_id'],
                                        'references' => ['type_ops',
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
                    'company_id'         => 1,
                    'tier_id'            => 1,
                    'type_op_id'         => 1,
                    'label'              => 'Lorem ipsum dolor sit amet',
                    'total_included_vat' => 1.5,
                    'total_without_vat'  => 1.5,
                    'total_vat'          => 1.5,
                    'vat'                => 1,
                    'due_date'           => '2019-05-02',
                    'draft'              => 1,
                    'commentspublic'     => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'commentsprivate'    => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'accounted'          => 1,
                    'created'            => '2019-05-02 21:49:31',
                    'modified'           => '2019-05-02 21:49:31',
                    'balance'            => 1,
                    'state'              => 1
                ],
            ];
            parent::init();
        }
    }
