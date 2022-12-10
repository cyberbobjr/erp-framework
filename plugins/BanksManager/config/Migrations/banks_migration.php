<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {
            $this->table('banks')
                 ->addColumn('name', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('accountnumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('cash', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('designation', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('address', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 50,
                     'null'    => TRUE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('contact', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('iban', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('phonenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 10,
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
                 ->create();
        }

        public function down()
        {
            $this->table('banks')->drop()->save();
        }
    }
