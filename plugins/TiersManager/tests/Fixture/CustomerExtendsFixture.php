<?php

    namespace TiersManager\Test\Fixture;

    use Cake\TestSuite\Fixture\TestFixture;

    /**
     * CustomerExtendsFixture
     */
    class CustomerExtendsFixture extends TestFixture
    {
        /**
         * Table name
         *
         * @var string
         */
        public $table = 'customer_extends';
        /**
         * Fields
         *
         * @var array
         */
        // @codingStandardsIgnoreStart
        public $fields = [
            'id'   => [
                'type'          => 'integer',
                'length'        => 11,
                'unsigned'      => false,
                'null'          => false,
                'default'       => null,
                'comment'       => '',
                'autoIncrement' => true,
                'precision'     => null
            ],
            'tier_id'      => [
                'type'          => 'integer',
                'length'        => 11,
                'unsigned'      => false,
                'null'          => false,
                'default'       => null,
                'comment'       => '',
                'precision'     => null,
                'autoIncrement' => null
            ],
            '_indexes'     => [
                'fk_user' => [
                    'type'    => 'index',
                    'columns' => ['tier_id'],
                    'length'  => []
                ],
            ],
            '_constraints' => [
                'primary' => [
                    'type'    => 'primary',
                    'columns' => ['id'],
                    'length'  => []
                ],
                'fk_user' => [
                    'type'       => 'foreign',
                    'columns'    => ['tier_id'],
                    'references' => [
                        'tiers',
                        'id'
                    ],
                    'update'     => 'noAction',
                    'delete'     => 'noAction',
                    'length'     => []
                ],
            ],
            '_options'     => [
                'engine'    => 'InnoDB',
                'collation' => 'utf8_general_ci'
            ],
        ];
        // @codingStandardsIgnoreEnd

        /**
         * Init method
         *
         * @return void
         */
        public function init()
        {
            $this->records = [

            ];
            parent::init();
        }
    }
