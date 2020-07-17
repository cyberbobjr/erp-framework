<?php

    namespace UserManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * UsersFixture
     */
    class UsersFixture extends TestFixture
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
            'username'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'fullname'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'password'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'email'        => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => FALSE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'avatar'       => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
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
            'firstname'    => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'lastname'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'civ'          => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'sex'          => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'badge'        => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'role'         => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'phonenumber'  => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'uuid'         => ['type'      => 'uuid',
                               'length'    => NULL,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'comment'   => '',
                               'precision' => NULL],
            'last_login'   => ['type'      => 'datetime',
                               'length'    => NULL,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'comment'   => '',
                               'precision' => NULL],
            'address'      => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'address1'     => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'zipcode'      => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'city'         => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'lat'          => ['type'      => 'float',
                               'length'    => NULL,
                               'precision' => NULL,
                               'unsigned'  => FALSE,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'comment'   => ''],
            'lng'          => ['type'      => 'float',
                               'length'    => NULL,
                               'precision' => NULL,
                               'unsigned'  => FALSE,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'comment'   => ''],
            'profile_path' => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'access_token' => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'profile'      => ['type'      => 'text',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL],
            'active'       => ['type'      => 'boolean',
                               'length'    => NULL,
                               'null'      => FALSE,
                               'default'   => '0',
                               'comment'   => '',
                               'precision' => NULL],
            'social_type'  => ['type'          => 'integer',
                               'length'        => 11,
                               'unsigned'      => FALSE,
                               'null'          => TRUE,
                               'default'       => NULL,
                               'comment'       => 'Type de compte, si null = manuel, si 1 = google, etc.',
                               'precision'     => NULL,
                               'autoIncrement' => NULL],
            'stripe'       => ['type'      => 'string',
                               'length'    => 255,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL,
                               'fixed'     => NULL],
            'ip'           => ['type'      => 'text',
                               'length'    => NULL,
                               'null'      => TRUE,
                               'default'   => NULL,
                               'collate'   => 'utf8_general_ci',
                               'comment'   => '',
                               'precision' => NULL],
            'archive'      => ['type'      => 'boolean',
                               'length'    => NULL,
                               'null'      => TRUE,
                               'default'   => '0',
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
                    'id'           => 1,
                    'username'     => 'bmarchand',
                    'fullname'     => 'Benjamin MARCHAND',
                    'password'     => 'Lorem ipsum dolor sit amet',
                    'email'        => 'cyberbobjr@yahoo.com',
                    'avatar'       => 'Lorem ipsum dolor sit amet',
                    'created'      => '2019-04-26 18:54:32',
                    'modified'     => '2019-04-26 18:54:32',
                    'firstname'    => 'Benjamin',
                    'lastname'     => 'MARCHAND',
                    'civ'          => 'Lorem ipsum dolor sit amet',
                    'sex'          => 'Lorem ipsum dolor sit amet',
                    'badge'        => 'Lorem ipsum dolor sit amet',
                    'role'         => 'Lorem ipsum dolor sit amet',
                    'phonenumber'  => 'Lorem ipsum dolor sit amet',
                    'uuid'         => '079a2927-dfb6-4c47-bfe3-1ffaa19ae956',
                    'last_login'   => '2019-04-26 18:54:32',
                    'address'      => 'Lorem ipsum dolor sit amet',
                    'address1'     => 'Lorem ipsum dolor sit amet',
                    'zipcode'      => 'Lorem ipsum dolor sit amet',
                    'city'         => 'Lorem ipsum dolor sit amet',
                    'lat'          => 1,
                    'lng'          => 1,
                    'profile_path' => 'Lorem ipsum dolor sit amet',
                    'access_token' => 'Lorem ipsum dolor sit amet',
                    'profile'      => '',
                    'active'       => 1,
                    'social_type'  => 1,
                    'stripe'       => 'Lorem ipsum dolor sit amet',
                    'ip'           => '',
                    'archive'      => 0
                ],
            ];
            parent::init();
        }
    }