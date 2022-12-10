<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {

            $this->table('properties')
                 ->addColumn('designation', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address1', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('address2', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('lotnumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('floor', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('number', 'string', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('building', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('comments', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lease_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
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
                 ->addIndex(
                     [
                         'company_id',
                     ]
                 )
                 ->create();
        }

        public function down()
        {
            $this->dropTable('properties');
        }
    }
