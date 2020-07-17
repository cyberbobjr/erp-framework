<?php

    declare(strict_types=1);

    use Migrations\AbstractMigration;

    class CreateTiers extends AbstractMigration
    {
        /**
         * Change Method.
         *
         * More information on this method is available here:
         * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
         *
         * @return void
         */
        public function change()
        {
            $this->table('tiers')
                 ->addColumn('type_tier', 'integer', ['default' => 1, 'limit' => 11, 'null' => FALSE, 'comments' => '1:Customer, 2 : Supplier'])
                 ->addColumn('lastname', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('firstname', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('company_name', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('address1', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('address2', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('zipcode', 'string', ['default' => NULL, 'limit' => 50, 'null' => TRUE,])
                 ->addColumn('city', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('country', 'string', ['default' => NULL, 'limit' => 100, 'null' => TRUE,])
                 ->addColumn('phonenumber', 'string', ['default' => NULL, 'limit' => 25, 'null' => TRUE,])
                 ->addColumn('faxnumber', 'string', ['default' => NULL, 'limit' => 25, 'null' => TRUE,])
                 ->addColumn('mobilenumber', 'string', ['default' => NULL, 'limit' => 25, 'null' => TRUE,])
                 ->addColumn('comments', 'text', ['default' => NULL, 'limit' => NULL, 'null' => TRUE,])
                 ->addColumn('vat_intra', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('email', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('picture', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addTimestamps('created', 'modified')
                 ->create();
        }
    }
