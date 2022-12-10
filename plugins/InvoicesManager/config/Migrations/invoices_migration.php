<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {
            $this->table('invoices')
                 ->addColumn('number', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('total_included_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('total_without_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('total_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('comments', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('accounted', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('paid', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('balance', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
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

            $this->table('invoicedetails')
                 ->addColumn('invoice_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('total_without_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('total_included_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('total_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
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
        }

        public function down()
        {
            $this->dropTable('invoice_details');
            $this->dropTable('invoices');
        }
    }
