<?php

    namespace PaymentsManager\Model\Table;

    use Cake\ORM\Table;

    /**
     * Class OperationsReglementsTable
     * @property \Cake\ORM\Table|\Cake\ORM\Association\BelongsTo $Operations
     * @property \Cake\ORM\Association\BelongsTo $Reglements
     * @package App\Model\Table
     * @property \Cake\ORM\Table|\Cake\ORM\Association\BelongsTo $Payments
     * @mixin \Cake\ORM\Behavior\TimestampBehavior
     */
    class OperationsPaymentsTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->setTable('OperationsManager.operations_payments');
            $this->belongsTo('OperationsManager.Operations');
            $this->belongsTo('PaymentsManager.Payments');
        }

        public function supprimer($id = NULL)
        {
            if (!is_null($id) && $this->exists(['id' => $id])) {
                $entite = $this->get($id);
                return $this->delete($entite);
            } else {
                return FALSE;
            }
        }

    }

?>
