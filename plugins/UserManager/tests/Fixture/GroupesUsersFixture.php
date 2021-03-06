<?php

    namespace UserManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * GroupesUsersFixture
     */
    class GroupesUsersFixture extends TestFixture
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
            'users_id'     => ['type'          => 'integer',
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
                'users_id'   => ['type'    => 'index',
                                 'columns' => ['users_id'],
                                 'length'  => []],
            ],
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
            parent::init();
        }
    }
