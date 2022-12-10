<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {
            $this->table('operations')
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('type_op_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('state', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('total_included_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
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
                 ->addColumn('vat', 'boolean', [
                     'default' => TRUE,
                     'limit'   => 1,
                     'null'    => FALSE,
                 ])
                 ->addColumn('due_date', 'date', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('draft', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('commentspublic', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('commentsprivate', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
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
                 ->addColumn('balance', 'float', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addIndex(
                     [
                         'lease_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'company_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'tier_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'type_op_id',
                     ]
                 )
                 ->create();

            $this->table('operationdetails')
                 ->addColumn('operation_id', 'integer', [
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
                     'null'      => TRUE,
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
                 ->addColumn('vat_id', 'integer', [
                     'default' => '8',
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('vatrate', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('type_operationdetail_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
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
                 ->addIndex(
                     [
                         'operation_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'vat_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'type_operationdetail_id',
                     ]
                 )
                 ->create();

            $this->table('type_operationdetails')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('accounting_plan_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('code_tiers', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('rent', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
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

            $this->table('type_ops')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('plugin', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('chooseable', 'boolean', [
                     'default' => TRUE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('receipt', 'boolean', [
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
                 ->create();
        }

        public function down()
        {
            $this->dropTable('operationdetails');
            $this->dropTable('operations');
            $this->dropTable('type_operationdetails');
            $this->dropTable('type_ops');
        }
    }
