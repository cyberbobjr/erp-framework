<?php
namespace OperationsManager\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LeasesFixture
 */
class LeasesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'designation' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'company_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vat_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'property_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tier_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type_periodicity_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'startdate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'enddate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'planned' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'value_index' => ['type' => 'decimal', 'length' => 20, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'indice_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'comments' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'property_id' => ['type' => 'index', 'columns' => ['property_id'], 'length' => []],
            'company_id' => ['type' => 'index', 'columns' => ['company_id'], 'length' => []],
            'tier_id' => ['type' => 'index', 'columns' => ['tier_id'], 'length' => []],
            'vat_id' => ['type' => 'index', 'columns' => ['vat_id'], 'length' => []],
            'type_periodicity_id' => ['type' => 'index', 'columns' => ['type_periodicity_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'leases_ibfk_1' => ['type' => 'foreign', 'columns' => ['property_id'], 'references' => ['properties', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'leases_ibfk_2' => ['type' => 'foreign', 'columns' => ['property_id'], 'references' => ['properties', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'leases_ibfk_3' => ['type' => 'foreign', 'columns' => ['company_id'], 'references' => ['companies', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'leases_ibfk_4' => ['type' => 'foreign', 'columns' => ['tier_id'], 'references' => ['tiers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'leases_ibfk_5' => ['type' => 'foreign', 'columns' => ['tier_id'], 'references' => ['tiers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'leases_ibfk_6' => ['type' => 'foreign', 'columns' => ['vat_id'], 'references' => ['vats', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'leases_ibfk_7' => ['type' => 'foreign', 'columns' => ['vat_id'], 'references' => ['vats', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'leases_ibfk_8' => ['type' => 'foreign', 'columns' => ['type_periodicity_id'], 'references' => ['type_periodicities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'leases_ibfk_9' => ['type' => 'foreign', 'columns' => ['type_periodicity_id'], 'references' => ['type_periodicities', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
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
            [
                'id' => 1,
                'designation' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'vat_id' => 1,
                'property_id' => 1,
                'tier_id' => 1,
                'type_periodicity_id' => 1,
                'startdate' => '2019-05-02',
                'enddate' => '2019-05-02',
                'planned' => 1,
                'value_index' => 1.5,
                'indice_id' => 1,
                'comments' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'active' => 1,
                'created' => '2019-05-02 20:36:59',
                'modified' => '2019-05-02 20:36:59'
            ],
        ];
        parent::init();
    }
}
