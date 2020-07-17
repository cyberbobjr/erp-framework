<?php

    declare(strict_types=1);

    use Migrations\AbstractMigration;

    class CreateDocuments extends AbstractMigration
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
            $this->table('documents')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('filepath', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addColumn('documenttype_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => FALSE,])
                 ->addColumn('related_id', 'integer', ['default' => NULL, 'limit' => 11, 'null' => TRUE,])
                 ->addColumn('related', 'string', ['default' => NULL, 'limit' => 255, 'null' => TRUE,])
                 ->addTimestamps('created', 'modified')
                 ->addForeignKey('documenttype_id', 'documenttypes', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
                 ->addIndex('documenttype_id')
                 ->create();

            $this->table('documenttypes')
                 ->addColumn('name', 'string', ['default' => NULL, 'limit' => 255, 'null' => FALSE,])
                 ->addTimestamps('created', 'modified')
                 ->create();
        }
    }
