<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {
            $this->table('configs')
                 ->addColumn('keyconfig', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('keyvalue', 'text', ['default' => NULL, 'limit' => NULL, 'null' => TRUE,])
                 ->create();

            $this->table('rights')
                 ->addColumn('code', 'string', ['default' => NULL, 'limit' => 45, 'null' => FALSE,])
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->create();

            $this->table('groups_rights')
                 ->addColumn('right_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('group_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                ->addForeignKey('right_id', 'rights', 'id')
                ->addForeignKey('group_id', 'groups', 'id')
                 ->addIndex(['group_id', 'right_id',])
                 ->create();

            $this->table('groups')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 45, 'null' => FALSE,])
                 ->addColumn('description', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->create();

            $this->table('groups_users')
                 ->addColumn('user_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('group_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addIndex(['groupes_id', 'users_id',])
                 ->addForeignKey('user_id', 'users', 'id')
                 ->addForeignKey('group_id', 'groups', 'id')
                 ->create();

            $this->table('languages')
                 ->addColumn(
                     'language_name',
                     'string',
                     [
                         'default' => NULL,
                         'limit'   => 80,
                         'null'    => TRUE,
                     ]
                 )
                 ->addColumn(
                     'language_name_fr',
                     'string',
                     [
                         'default' => NULL,
                         'limit'   => 80,
                         'null'    => TRUE,
                     ]
                 )
                 ->create();

            $this->table('countries')
                 ->addColumn(
                     'code',
                     'integer',
                     [
                         'default' => NULL,
                         'limit'   => 3,
                         'null'    => FALSE,
                     ]
                 )
                 ->addColumn(
                     'alpha2',
                     'string',
                     [
                         'default' => NULL,
                         'limit'   => 2,
                         'null'    => FALSE,
                     ]
                 )
                 ->addColumn(
                     'alpha3',
                     'string',
                     [
                         'default' => NULL,
                         'limit'   => 3,
                         'null'    => FALSE,
                     ]
                 )
                 ->addColumn(
                     'nom_en_gb',
                     'string',
                     [
                         'default' => NULL,
                         'limit'   => 45,
                         'null'    => FALSE,
                     ]
                 )
                 ->addColumn(
                     'nom_fr_fr',
                     'string',
                     [
                         'default' => NULL,
                         'limit'   => 45,
                         'null'    => FALSE,
                     ]
                 )
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
                 ->addColumn(
                     'tier_id',
                     'integer',
                     [
                         'default' => NULL,
                         'limit'   => 11,
                         'null'    => FALSE,
                     ]
                 )
                 ->addForeignKey(
                     'tier_id',
                     'tiers',
                     'id',
                     [
                         'update' => 'NO_ACTION',
                         'delete' => 'NO_ACTION'
                     ]
                 )
                 ->create();

            $this->table('vats')
                 ->addColumn(
                     'rate',
                     'decimal',
                     [
                         'default'   => NULL,
                         'null'      => FALSE,
                         'precision' => 5,
                         'scale'     => 2,
                     ]
                 )
                 ->create();
        }
    }
