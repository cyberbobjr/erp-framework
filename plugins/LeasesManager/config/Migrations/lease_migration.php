<?php

    use Migrations\AbstractMigration;

    class Initial extends AbstractMigration
    {
        public function up()
        {
            $this->table('leases')
                 ->addColumn('designation', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('vat_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('property_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('type_periodicity_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('startdate', 'date', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('enddate', 'date', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('planned', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('value_index', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 20,
                     'scale'     => 2,
                 ])
                 ->addColumn('indice_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('comments', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('active', 'boolean', [
                     'default' => TRUE,
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
                 ->addIndex(
                     [
                         'property_id',
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
                         'vat_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'type_periodicity_id',
                     ]
                 )
                 ->create();


            $this->table('rentsdetails')
                 ->addColumn('rent_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('type_operationdetail_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('total_without_vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('total_included_vat', 'decimal', [
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
                 ->addColumn('vat', 'decimal', [
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
                         'rent_id',
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

            $this->table('rents')
                 ->addColumn('lease_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('ref', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
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
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('vat', 'decimal', [
                     'default'   => NULL,
                     'null'      => TRUE,
                     'precision' => 10,
                     'scale'     => 2,
                 ])
                 ->addColumn('start_period', 'date', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('end_period', 'date', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('comments', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
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
                 ->addIndex(
                     [
                         'lease_id',
                     ]
                 )
                 ->create();
        }

        public function down()
        {
            $this->table('leases')->drop()->save();
            $this->dropTable('rentsdetails');
            $this->dropTable('rents');
        }
    }
