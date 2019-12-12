<?php

    namespace UserManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * DroitsGroupesFixture
     */
    class RightsGroupesFixture extends TestFixture
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
            'rights_id'    => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => FALSE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'groupes_id'   => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => FALSE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            '_indexes'     => [
                'groupes_id' => ['type'    => 'index',
                                 'columns' => ['groupes_id'],
                                 'length'  => []],
                'rights_id'  => ['type'    => 'index',
                                 'columns' => ['rights_id'],
                                 'length'  => []],
            ],
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
                    'id'         => 1,
                    'rights_id'  => 1,
                    'groupes_id' => 1
                ],
            ];
            parent::init();
        }
    }
