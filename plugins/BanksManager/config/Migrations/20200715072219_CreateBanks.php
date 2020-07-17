<?php

    declare(strict_types=1);

    use Migrations\AbstractMigration;

    class CreateBanks extends AbstractMigration
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
            $this->table('banks')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('cash', 'boolean', ['default' => NULL, 'null' => TRUE,])
                 ->addColumn('comments', 'text', ['default' => NULL, 'null' => TRUE,])
                 ->addColumn('address1', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('address2', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('zipcode', 'string', ['default' => NULL, 'limit' => 50, 'null' => TRUE,])
                 ->addColumn('city', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('country', 'string', ['default' => NULL, 'limit' => 100, 'null' => TRUE,])
                 ->addColumn('phonenumber', 'string', ['default' => NULL, 'limit' => 25, 'null' => TRUE,])
                 ->addColumn('faxnumber', 'string', ['default' => NULL, 'limit' => 25, 'null' => TRUE,])
                 ->addColumn('mobilenumber', 'string', ['default' => NULL, 'limit' => 25, 'null' => TRUE,])
                 ->addColumn('contactname', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addTimestamps('created', 'modified')
                 ->create();

            $this->table('bankaccounts')
                 ->addColumn('accountnumber', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('iban', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('bic', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('directdebit', 'boolean', ['default' => NULL, 'null' => TRUE,])
                 ->addColumn('rum', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('bank_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('company_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addTimestamps('created', 'modified')
                 ->addForeignKey('bank_id', 'banks', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                 ->addForeignKey('company_id', 'companies', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                 ->addIndex(['bank_id', 'company_id'])
                 ->create();
        }
    }
