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

            $this->table('banks')
                 ->addColumn('name', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('accountnumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('cash', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('designation', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('address', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 50,
                     'null'    => TRUE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('contact', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('iban', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('phonenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 10,
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
                 ->create();

            $this->table('properties')
                 ->addColumn('designation', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address1', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('address2', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('lotnumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('floor', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('number', 'string', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('building', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('comments', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('company_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lease_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
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
                         'company_id',
                     ]
                 )
                 ->create();

            $this->table('configs')
                 ->addColumn('keyconfig', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('documents')
                 ->addColumn('file', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('type_document_id', 'integer', [
                     'default' => '0',
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('ref_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
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

            $this->table('rights')
                 ->addColumn('code', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('rights_groupes')
                 ->addColumn('rights_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('groupes_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'groupes_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'rights_id',
                     ]
                 )
                 ->create();

            $this->table('events')
                 ->addColumn('ref_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('type_event_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('date', 'date', [
                     'default' => NULL,
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
                         'type_event_id',
                     ]
                 )
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

            $this->table('groupes')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addColumn('description', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('groupes_users')
                 ->addColumn('users_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('groupes_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'groupes_id',
                     ]
                 )
                 ->addIndex(
                     [
                         'users_id',
                     ]
                 )
                 ->create();

            $this->table('languages')
                 ->addColumn('language_name', 'string', [
                     'default' => NULL,
                     'limit'   => 80,
                     'null'    => TRUE,
                 ])
                 ->addColumn('language_name_fr', 'string', [
                     'default' => NULL,
                     'limit'   => 80,
                     'null'    => TRUE,
                 ])
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

            $this->table('countries')
                 ->addColumn('code', 'integer', [
                     'default' => NULL,
                     'limit'   => 3,
                     'null'    => FALSE,
                 ])
                 ->addColumn('alpha2', 'string', [
                     'default' => NULL,
                     'limit'   => 2,
                     'null'    => FALSE,
                 ])
                 ->addColumn('alpha3', 'string', [
                     'default' => NULL,
                     'limit'   => 3,
                     'null'    => FALSE,
                 ])
                 ->addColumn('nom_en_gb', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addColumn('nom_fr_fr', 'string', [
                     'default' => NULL,
                     'limit'   => 45,
                     'null'    => FALSE,
                 ])
                 ->addIndex(
                     [
                         'alpha2',
                     ],
                     ['unique' => TRUE]
                 )
                 ->addIndex(
                     [
                         'alpha3',
                     ],
                     ['unique' => TRUE]
                 )
                 ->addIndex(
                     [
                         'code',
                     ],
                     ['unique' => TRUE]
                 )
                 ->create();

            $this->table('companies')
                 ->addColumn('name', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('address1', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address2', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('phonenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('number', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('vat_intra', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('vat', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('capital', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('capital_floor', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
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
                 ->create();

            $this->table('customer_extends')
                 ->addColumn('tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addForeignKey(
                     'tier_id',
                     'tiers',
                     'id',
                     [
                         'update' => 'NO_ACTION',
                         'delete' => 'NO_ACTION'
                     ]
                 )
                 ->create();

            $this->table('customer_extends')
                 ->addColumn('tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->create();

            $this->table('tiers')
                 ->addColumn('type_tier_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => FALSE,
                 ])
                 ->addColumn('lastname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('firstname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('company_name', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('vat', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('address1', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address2', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('phonenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('mobilenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('officenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('comments', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('vat_intra', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('email', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('picture', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
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
                 ->create();

            $this->table('vats')
                 ->addColumn('rate', 'decimal', [
                     'default'   => NULL,
                     'null'      => FALSE,
                     'precision' => 5,
                     'scale'     => 2,
                 ])
                 ->create();

            $this->table('type_documents')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->create();

            $this->table('type_events')
                 ->addColumn('type', 'string', [
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

            $this->table('type_periodicities')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->create();

            $this->table('type_tiers')
                 ->addColumn('label', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('direction', 'integer', [
                     'default' => '0',
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('plan_id', 'integer', [
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
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

            $this->table('type_tiers')
                 ->insert([['label' => 'Customers'],
                           ['label' => 'Suppliers']])
                 ->save();

            $this->table('users')
                 ->addColumn('username', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('fullname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('password', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('email', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => FALSE,
                 ])
                 ->addColumn('avatar', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
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
                 ->addColumn('firstname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lastname', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('civ', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('sex', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('badge', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('role', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('phonenumber', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('uuid', 'uuid', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('last_login', 'datetime', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('address1', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('zipcode', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('city', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lat', 'float', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('lng', 'float', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('profile_path', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('access_token', 'string', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('profile', 'text', [
                     'default' => NULL,
                     'limit'   => 255,
                     'null'    => TRUE,
                 ])
                 ->addColumn('active', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => FALSE,
                 ])
                 ->addColumn('social_type', 'integer', [
                     'comment' => 'Type de compte, si null = manuel, si 1 = google, etc.',
                     'default' => NULL,
                     'limit'   => 11,
                     'null'    => TRUE,
                 ])
                 ->addColumn('ip', 'text', [
                     'default' => NULL,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->addColumn('archive', 'boolean', [
                     'default' => FALSE,
                     'limit'   => NULL,
                     'null'    => TRUE,
                 ])
                 ->create();

            $this->table('leases')
                 ->addForeignKey(
                     'property_id',
                     'properties',
                     'id',
                     [
                         'update' => 'NO_ACTION',
                         'delete' => 'NO_ACTION'
                     ]
                 )
                 ->addForeignKey(
                     'property_id',
                     'properties',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'company_id',
                     'companies',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'tier_id',
                     'tiers',
                     'id',
                     [
                         'update' => 'NO_ACTION',
                         'delete' => 'NO_ACTION'
                     ]
                 )
                 ->addForeignKey(
                     'tier_id',
                     'tiers',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'vat_id',
                     'vats',
                     'id',
                     [
                         'update' => 'NO_ACTION',
                         'delete' => 'NO_ACTION'
                     ]
                 )
                 ->addForeignKey(
                     'vat_id',
                     'vats',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'type_periodicity_id',
                     'type_periodicities',
                     'id',
                     [
                         'update' => 'NO_ACTION',
                         'delete' => 'NO_ACTION'
                     ]
                 )
                 ->addForeignKey(
                     'type_periodicity_id',
                     'type_periodicities',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();


            $this->table('properties')
                 ->addForeignKey(
                     'company_id',
                     'companies',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('documents')
                 ->addForeignKey(
                     'type_document_id',
                     'type_documents',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('events')
                 ->addForeignKey(
                     'type_event_id',
                     'type_events',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('rentsdetails')
                 ->addForeignKey(
                     'rent_id',
                     'rents',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'vat_id',
                     'vats',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'type_operationdetail_id',
                     'type_operationdetails',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('rents')
                 ->addForeignKey(
                     'lease_id',
                     'leases',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('operationdetails')
                 ->addForeignKey(
                     'operation_id',
                     'operations',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'CASCADE'
                     ]
                 )
                 ->addForeignKey(
                     'vat_id',
                     'vats',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'type_operationdetail_id',
                     'type_operationdetails',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('operations')
                 ->addForeignKey(
                     'lease_id',
                     'leases',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'company_id',
                     'companies',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'tier_id',
                     'tiers',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'type_op_id',
                     'type_ops',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('operations_payments')
                 ->addForeignKey(
                     'operation_id',
                     'operations',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->addForeignKey(
                     'payment_id',
                     'payments',
                     'id',
                     [
                         'update' => 'RESTRICT',
                         'delete' => 'RESTRICT'
                     ]
                 )
                 ->update();

            $this->table('payments')
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
                 ->update();

        }

        public function down()
        {
            $this->table('leases')
                 ->dropForeignKey(
                     'property_id'
                 )
                 ->dropForeignKey(
                     'company_id'
                 )
                 ->dropForeignKey(
                     'tier_id'
                 )
                 ->dropForeignKey(
                     'vat_id'
                 )
                 ->dropForeignKey(
                     'type_periodicity_id'
                 );


            $this->table('properties')
                 ->dropForeignKey(
                     'company_id'
                 );

            $this->table('documents')
                 ->dropForeignKey(
                     'type_document_id'
                 );

            $this->table('events')
                 ->dropForeignKey(
                     'type_event_id'
                 );

            $this->table('rentsdetails')
                 ->dropForeignKey(
                     'rent_id'
                 )
                 ->dropForeignKey(
                     'vat_id'
                 )
                 ->dropForeignKey(
                     'type_operationdetail_id'
                 );

            $this->table('rents')
                 ->dropForeignKey(
                     'lease_id'
                 );

            $this->table('operationdetails')
                 ->dropForeignKey(
                     'operation_id'
                 )
                 ->dropForeignKey(
                     'vat_id'
                 )
                 ->dropForeignKey(
                     'type_operationdetail_id'
                 );

            $this->table('operations')
                 ->dropForeignKey(
                     'lease_id'
                 )
                 ->dropForeignKey(
                     'company_id'
                 )
                 ->dropForeignKey(
                     'tier_id'
                 )
                 ->dropForeignKey(
                     'type_op_id'
                 );

            $this->table('operations_payments')
                 ->dropForeignKey(
                     'operation_id'
                 )
                 ->dropForeignKey(
                     'payment_id'
                 );

            $this->table('payments')
                 ->dropForeignKey(
                     'bank_id'
                 )
                 ->dropForeignKey(
                     'type_payment_id'
                 );

            $this->table('customer_extends')
                 ->dropForeignKey('tier_id');

            $this->dropTable('leases');
            $this->dropTable('banks');
            $this->dropTable('properties');
            $this->dropTable('configs');
            $this->dropTable('documents');
            $this->dropTable('rights');
            $this->dropTable('rights_groupes');
            $this->dropTable('events');
            $this->dropTable('invoice_details');
            $this->dropTable('invoices');
            $this->dropTable('factures_payments');
            $this->dropTable('groupes');
            $this->dropTable('groupes_users');
            $this->dropTable('languages');
            $this->dropTable('rentsdetails');
            $this->dropTable('rents');
            $this->dropTable('operationdetails');
            $this->dropTable('operations');
            $this->dropTable('operations_payments');
            $this->dropTable('payments');
            $this->dropTable('countries');
            $this->dropTable('roles');
            $this->dropTable('companies');
            $this->dropTable('tiers');
            $this->dropTable('customer_extends');
            $this->dropTable('vats');
            $this->dropTable('type_documents');
            $this->dropTable('type_events');
            $this->dropTable('type_operationdetails');
            $this->dropTable('type_ops');
            $this->dropTable('type_payments');
            $this->dropTable('type_periodicities');
            $this->dropTable('type_tiers');
            $this->dropTable('users');
        }
    }
