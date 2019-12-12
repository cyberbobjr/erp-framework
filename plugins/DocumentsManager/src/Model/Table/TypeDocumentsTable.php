<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeDocumentstiers Model
 *
 * @property \App\Model\Table\DocumentstiersTable|\Cake\ORM\Association\HasMany $Documentstiers
 *
 * @method \App\Model\Entity\TypeDocumentstier get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeDocumentstier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeDocumentstier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeDocumentstier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeDocumentstier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeDocumentstier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeDocumentstier findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeDocumentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');

        $this->setTable('type_documentstiers');
        $this->setDisplayField('libelle');
        $this->setPrimaryKey('id');

        $this->hasMany('Documentstiers', [
            'foreignKey' => 'type_documentstier_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('libelle', 'create')
            ->notEmpty('libelle');

        return $validator;
    }
}
