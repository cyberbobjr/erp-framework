<?php

    declare(strict_types=1);

    use Migrations\AbstractMigration;

    class CreateInvoices extends AbstractMigration
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
            $this->table('invoices')
                 ->addColumn('number', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('title', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('company_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('thirdparty_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('invoicestatut', 'integer', ['default' => 1, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('contactname', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('address1', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('address2', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('zipcode', 'string', ['default' => NULL, 'limit' => 50, 'null' => TRUE,])
                 ->addColumn('city', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('country', 'string', ['default' => NULL, 'limit' => 100, 'null' => TRUE,])
                 ->addColumn('total_excluded_vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('discount', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('vat2', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_vat2', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_included_vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('publiccomments', 'text', ['default' => NULL, 'limit' => NULL, 'null' => TRUE,])
                 ->addColumn('privatecomments', 'text', ['default' => NULL, 'limit' => NULL, 'null' => TRUE,])
                 ->addTimestamps('created', 'modified')
                 ->create();

            $this->table('invoicestatuts')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addTimestamps('created', 'modified')
                 ->create();

            $this->table('invoicelines')
                 ->addColumn('invoice_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('item_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => TRUE,])
                 ->addColumn('code', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('qty', 'integer', ['default' => NULL, 'null' => TRUE, 'limit' => 11])
                 ->addColumn('unit_price', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('discount', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_excluded_vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('vat2', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_vat2', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('total_included_vat', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addTimestamps('created', 'modified')
                 ->addForeignKey('invoice_id', 'invoices', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                 ->addForeignKey('item_id', 'items', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
                 ->addIndex(['related_id', 'item_id'])
                 ->create();
        }
    }
