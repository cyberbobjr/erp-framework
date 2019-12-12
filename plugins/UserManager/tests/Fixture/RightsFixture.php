<?php

    namespace UserManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * DroitsFixture
     */
    class RightsFixture extends TestFixture
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
            'code'         => ['type'      => 'string',
                               'length'    => 45,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'latin1_swedish_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'label'        => ['type'      => 'string',
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
                    'code'  => 'ADMIN',
                    'label' => 'ADMIN'
                ],
            ];
            parent::init();
        }
    }
