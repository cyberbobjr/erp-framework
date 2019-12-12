<?php
namespace UserManager\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Josegonzalez\Upload\File\Path\ProcessorInterface;

class Base64Processor implements ProcessorInterface
{
    /**
     * Table instance.
     *
     * @var \Cake\ORM\Table
     */
    protected $table;

    /**
     * Entity instance.
     *
     * @var \Cake\ORM\Entity
     */
    protected $entity;

    /**
     * Array of uploaded data for this field
     *
     * @var array
     */
    protected $data;

    /**
     * Name of field
     *
     * @var string
     */
    protected $field;

    /**
     * Settings for processing a path
     *
     * @var array
     */
    protected $settings;

    /**
     * MimeType of image
     * @var
     */
    protected $_mimetype;

    /**
     * Constructor
     *
     * @param \Cake\ORM\Table $table the instance managing the entity
     * @param \Cake\ORM\Entity $entity the entity to construct a path for.
     * @param array $data the data being submitted for a save
     * @param string $field the field for which data will be saved
     * @param array $settings the settings for the current field
     */
    public function __construct(Table $table, Entity $entity, $data, $field, $settings)
    {
        $this->table = $table;
        $this->entity = $entity;
        $this->data = $data;
        $this->field = $field;
        $this->settings = $settings;
        $this->_mimetype = $data['type'];
    }

    /**
     * @param $filename
     * @return string
     */
    private function _readFile($filename)
    {
        return file_get_contents($filename);
    }

    public function basepath()
    {
        // TODO: Implement basepath() method.
    }

    /**
     * @return string
     */
    public function filename()
    {
        $base64 = base64_encode($this->_readFile($this->data['tmp_name']));
        return 'data:' . $this->data['type'] . ';base64,' . $base64;
        // TODO: Implement filename() method.
    }
}
