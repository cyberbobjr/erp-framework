<?php

    declare(strict_types=1);

    use Migrations\AbstractMigration;

    class CreatePayments extends AbstractMigration
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
            $this->table('payments')
                 ->addColumn('bank_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE])
                 ->addColumn('amount', 'decimal', ['default' => NULL, 'null' => FALSE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('related_id', 'integer', ['default' => NULL, 'null' => TRUE, 'limit' => 11,])
                 ->addColumn('related', 'string', ['default' => NULL, 'null' => TRUE, 'limit' => 50,])
                 ->addColumn('datepayment', 'date', ['default' => NULL, 'null' => FALSE,])
                 ->addColumn('type_payment_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addTimestamps('created', 'modified')
                 ->addForeignKey(
                     'bank_id',
                     'banks',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'type_payment_id',
                     'type_payments',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->create();

            $this->table('type_payments')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addTimestamps('created', 'modified')
                 ->create();
        }
    }
