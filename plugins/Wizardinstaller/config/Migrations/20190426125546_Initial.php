<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up(): void
        {
            $this->table('configs')
                 ->addColumn('keyconfig', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('rights')
                 ->addColumn('code', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('rights_groupes')
                 ->addColumn('rights_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('groupes_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'groupes_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'rights_id',
                     ]
                 )
                 ->create();

            $this->table('events')
                 ->addColumn('ref_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('type_event_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('date', 'date', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('created', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('modified', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'type_event_id',
                     ]
                 )
                 ->create();

            $this->table('groupes')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addColumn('description', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('groupes_users')
                 ->addColumn('users_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('groupes_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'groupes_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'users_id',
                     ]
                 )
                 ->create();

            $this->table('languages')
                 ->addColumn('language_name', 'string', [
                     'default' => NULL,
                     'limit'   => 80,
                     'null'    => TRUE,
                 ])
                 ->addColumn('language_name_fr', 'string', [
                     'default' => NULL,
                     'limit'   => 80,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('countries')
                 ->addColumn('code', 'integer', [
                     'default' => NULL,
                     'limit'   => 3,
                     'null'    => FALSE,
                 ])
                 ->addColumn('alpha2', 'string', [
                     'default' => NULL,
                     'limit'   => 2,
                     'null'    => FALSE,
                 ])
                 ->addColumn('alpha3', 'string', [
                     'default' => NULL,
                     'limit'   => 3,
                     'null'    => FALSE,
                 ])
                 ->addColumn('nom_en_gb', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addColumn('nom_fr_fr', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'alpha2',
                     ],
                     ['unique' => TRUE]
                 )
                 ->addIndex(
                     [
                         'alpha3',
                     ],
                     ['unique' => TRUE]
                 )
                 ->addIndex(
                     [
                         'code',
                     ],
                     ['unique' => TRUE]
                 )
                 ->create();

            $this->table('customer_extends')
                 ->addColumn('tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->create();

            $this->table('vats')
                 ->addColumn('rate', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 5,
                     'scale'     => 2,
                 ])
                 ->create();


            $this->table('type_events')
                 ->addColumn('type', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('created', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('modified', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('type_periodicities')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->create();

            $this->table('users')
                 ->addColumn('username', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('fullname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('password', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('email', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('avatar', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('created', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('modified', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('firstname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lastname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('civ', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('sex', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('badge', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('role', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('phonenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('uuid', 'uuid', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('last_login', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address1', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lat', 'float', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lng', 'float', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('profile_path', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('access_token', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('profile', 'text', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('active', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('social_type', 'integer', [
                     'comment' => 'Type de compte, si null = manuel, si 1 = google, etc.',
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('ip', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('archive', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->create();

        }

        public function down()
        {
            $this->table('configs')->drop()->save();
            $this->dropTable('rights');
            $this->dropTable('rights_groupes');
            $this->dropTable('events');
            $this->dropTable('groupes');
            $this->dropTable('groupes_users');
            $this->dropTable('languages');
            $this->dropTable('countries');
            $this->dropTable('roles');
            $this->dropTable('customer_extends');
            $this->dropTable('vats');
            $this->dropTable('type_events');
            $this->dropTable('type_periodicities');
            $this->dropTable('users');
        }
    }
