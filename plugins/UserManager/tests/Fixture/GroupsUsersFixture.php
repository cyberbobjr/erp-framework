<?php

    namespace UserManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * GroupsUsersFixture
     */
    class GroupsUsersFixture extends TestFixture
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
            'groups_id'    => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => FALSE,
                               'default'       => NULL,
                               'comment'       => '',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            '_indexes'     => [
                'groups_id' => ['type'    => 'index',
                                'columns' => ['groups_id'],
                                'length'  => []],
                'users_id'  => ['type'    => 'index',
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
