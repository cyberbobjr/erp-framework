<?php

    namespace OperationsManager\Model\Table;

    use Cake\ORM\Table;

    /**
     * Détermine les différents types d'opérations possibles
     * sens_tiers : détermine dans quel sens le compte tiers est mouvementé (0 = débit ou 1 = crédit)
     * sens_societe : détermine dans quel sens le compte société est mouvementé (0 = débit ou 1 = crédit)
     * plan_id : détermine le numéro de compte du plan comptable de la société qui est concerné par le mouvement
     * Class TypeOperationsTable
     * @package App\Model\Table
     * @property \Cake\ORM\Table|\Cake\ORM\Association\BelongsTo $Plancomptas
     * @method \OperationsManager\Model\Entity\TypeOperationDetail get($primaryKey, $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail newEntity($data = NULL, array $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail[] newEntities(array $data, array $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail[] patchEntities($entities, array $data, array $options = [])
     * @method \OperationsManager\Model\Entity\TypeOperationDetail findOrCreate($search, callable $callback = NULL, $options = [])
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class TypeOperationdetailsTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->setDisplayField('label');
            $this->setTable('type_operationdetails');
        }
    }

?>
