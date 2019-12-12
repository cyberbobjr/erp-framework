<?php

    namespace App\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * AppPluginsFixture
     */
    class AppPluginsFixture extends TestFixture
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
            'name'         => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'activated'    => ['type'      => 'boolean',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => NULL,
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
                    'id'        => 1,
                    'name'      => 'Lorem ipsum dolor sit amet',
                    'activated' => 1,
                    'created'   => '2019-05-04 21:08:46',
                    'modified'  => '2019-05-04 21:08:46'
                ],
            ];
            parent::init();
        }
    }
