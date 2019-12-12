<?php

    namespace UserManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * GroupesFixture
     */
    class GroupesFixture extends TestFixture
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
                               'length'    => 45,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'latin1_swedish_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'description'  => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'latin1_swedish_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            '_constraints' => [
                'primary' => ['type'    => 'primary',
                              'columns' => ['id'],
                              'length'  => []],
            ],
            '_options'     => [
                'engine'    => 'InnoDB',
                'collation' => 'latin1_swedish_ci'
            ],
        ];

        public $records = [
            [
                'id'          => 1,
                'label'       => 'ADMIN',
                'description' => 'Groupe administrateur'
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
            parent::init();
        }
    }
