<?php

    namespace OperationsManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * OperationdetailsFixture
     */
    class OperationdetailsFixture extends TestFixture
    {
        /**
         * Fields
         *
         * @var array
         */
        // @codingStandardsIgnoreStart
        public $fields = [
            'id'                      => ['type'          => 'integer',
                                          'length'        => 11,
                                          'unsigned'      => FALSE,
                                          'null'          => FALSE,
                                          'default'       => NULL,
                                          'comment'       => '',
                                          'autoIncrement' => TRUE,
                                          'precision'     => NULL],
            'operation_id'            => ['type'          => 'integer',
                                          'length'        => 11,
                                          'unsigned'      => FALSE,
                                          'null'          => FALSE,
                                          'default'       => NULL,
                                          'comment'       => '',
                                          'precision'     => NULL,
                                          'autoIncrement' => NULL],
            'label'                   => ['type'      => 'string',
                                          'length'    => 255,
                                          'null'      => FALSE,
                                          'default'   => NULL,
                                          'collate'   => 'utf8_general_ci',
                                          'comment'   => '',
                                          'precision' => NULL,
                                          'fixed'     => NULL],
            'total_included_vat'      => ['type'      => 'decimal',
                                          'length'    => 10,
                                          'precision' => 2,
                                          'unsigned'  => FALSE,
                                          'null'      => TRUE,
                                          'default'   => NULL,
                                          'comment'   => ''],
            'total_without_vat'       => ['type'      => 'decimal',
                                          'length'    => 10,
                                          'precision' => 2,
                                          'unsigned'  => FALSE,
                                          'null'      => TRUE,
                                          'default'   => NULL,
                                          'comment'   => ''],
            'total_vat'               => ['type'      => 'decimal',
                                          'length'    => 10,
                                          'precision' => 2,
                                          'unsigned'  => FALSE,
                                          'null'      => TRUE,
                                          'default'   => NULL,
                                          'comment'   => ''],
            'vat_id'                  => ['type'          => 'integer',
                                          'length'        => 11,
                                          'unsigned'      => FALSE,
                                          'null'          => FALSE,
                                          'default'       => '8',
                                          'comment'       => '',
                                          'precision'     => NULL,
                                          'autoIncrement' => NULL],
            'vatrate'                 => ['type'      => 'decimal',
                                          'length'    => 10,
                                          'precision' => 2,
                                          'unsigned'  => FALSE,
                                          'null'      => TRUE,
                                          'default'   => NULL,
                                          'comment'   => ''],
            'type_operationdetail_id' => ['type'          => 'integer',
                                          'length'        => 11,
                                          'unsigned'      => FALSE,
                                          'null'          => FALSE,
                                          'default'       => NULL,
                                          'comment'       => '',
                                          'precision'     => NULL,
                                          'autoIncrement' => NULL],
            'created'                 => ['type'      => 'datetime',
                                          'length'    => NULL,
                                          'null'      => FALSE,
                                          'default'   => NULL,
                                          'comment'   => '',
                                          'precision' => NULL],
            'modified'                => ['type'      => 'datetime',
                                          'length'    => NULL,
                                          'null'      => FALSE,
                                          'default'   => NULL,
                                          'comment'   => '',
                                          'precision' => NULL],
            '_indexes'                => [
                'operation_id'            => ['type'    => 'index',
                                              'columns' => ['operation_id'],
                                              'length'  => []],
                'vat_id'                  => ['type'    => 'index',
                                              'columns' => ['vat_id'],
                                              'length'  => []],
                'type_operationdetail_id' => ['type'    => 'index',
                                              'columns' => ['type_operationdetail_id'],
                                              'length'  => []],
            ],
            '_constraints'            => [
                'primary'                 => ['type'    => 'primary',
                                              'columns' => ['id'],
                                              'length'  => []],
                'operationdetails_ibfk_1' => ['type'       => 'foreign',
                                              'columns'    => ['operation_id'],
                                              'references' => ['operations',
                                                               'id'],
                                              'update'     => 'restrict',
                                              'delete'     => 'cascade',
                                              'length'     => []],
                'operationdetails_ibfk_2' => ['type'       => 'foreign',
                                              'columns'    => ['vat_id'],
                                              'references' => ['vats',
                                                               'id'],
                                              'update'     => 'restrict',
                                              'delete'     => 'restrict',
                                              'length'     => []],
                'operationdetails_ibfk_3' => ['type'       => 'foreign',
                                              'columns'    => ['type_operationdetail_id'],
                                              'references' => ['type_operationdetails',
                                                               'id'],
                                              'update'     => 'restrict',
                                              'delete'     => 'restrict',
                                              'length'     => []],
            ],
            '_options'                => [
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
                    'id'                      => 1,
                    'operation_id'            => 1,
                    'label'                   => 'Lorem ipsum dolor sit amet',
                    'total_included_vat'      => 120,
                    'total_without_vat'       => 100,
                    'total_vat'               => 20,
                    'vat_id'                  => 1,
                    'vatrate'                 => 20.0,
                    'type_operationdetail_id' => 1,
                    'created'                 => '2019-05-03 10:34:16',
                    'modified'                => '2019-05-03 10:34:16'
                ],
            ];
            parent::init();
        }
    }
