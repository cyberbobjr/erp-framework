<?php

    declare(strict_types=1);

    use Migrations\AbstractMigration;

    class CreateItems extends AbstractMigration
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
            $this->table('items')
                 ->addColumn('code', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('barcode', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('default_sell_price', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('default_buy_price', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('default_weight', 'decimal', ['default' => NULL, 'null' => TRUE, 'precision' => 10, 'scale' => 2,])
                 ->addColumn('default_size', 'string', ['default' => NULL, 'null' => TRUE, 'limit' => 255])
                 ->addColumn('default_color', 'string', ['default' => NULL, 'null' => TRUE, 'limit' => 255])
                 ->addColumn('default_brand', 'string', ['default' => NULL, 'null' => TRUE, 'limit' => 255])
                 ->addColumn('default_packaging', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addColumn('itemtype_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('parent_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => TRUE,])
                 ->addColumn('lft', 'integer', ['default' => NULL, 'limit' => 11, 'null' => TRUE,])
                 ->addColumn('rght', 'integer', ['default' => NULL, 'limit' => 11, 'null' => TRUE,])
                 ->addTimestamps('created', 'modified')
                 ->addForeignKey('itemtype_id', 'itemtypes', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
                 ->create();

            $this->table('itemtypes')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addTimestamps('created', 'modified')
                 ->create();
        }
    }
