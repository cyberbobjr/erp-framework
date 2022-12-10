<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {

            $this->table('invoices_payments')
                 ->addColumn('invoice_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('payment_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('total', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 10,
                     'scale'     => 2,
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


            $this->table('operations_payments')
                 ->addColumn('payment_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('operation_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('amount', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 10,
                     'scale'     => 2,
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
                         'operation_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'payment_id',
                     ]
                 )
                 ->create();

            $this->table('payments')
                 ->addColumn('bank_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('amount', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('accounted', 'boolean', [
                     'default' => FALSE,
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
                 ->addColumn('type_payment_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->create();

            $this->table('type_payments')
                 ->addColumn('label', 'string', [
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

        }

        public function down()
        {
            $this->dropTable('factures_payments');
            $this->dropTable('operations_payments');
            $this->dropTable('type_payments');
            $this->dropTable('payments');
        }
    }
