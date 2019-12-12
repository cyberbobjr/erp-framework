<?php

    namespace OperationsManager\View\Cell;

    use Cake\View\Cell;

    /**
     * Class OperationsCell
     * @package App\View\Cell
     * @property \OperationsManager\Model\Table\OperationsTable $Operations
     */
    class OperationsCell extends Cell
    {

        public function display()
        {
            $this->loadModel('OperationsManager.Operations');
            $operations = $this->Operations->find()
                                           ->contain(['Customers',
                                                      'Companies',
                                                      'TypeOps'])
                                           ->order(['Operations.created' => 'DESC'])
                                           ->limit(5);
            $this->set(compact('operations'));
        }

        /**
         * Affiche la somme des montants facturés et la somme des réglements sur les 5 derniers mois
         */
        public function revenus()
        {
            $this->loadModel('OperationsManager.Operations');

            // récupération des montants facturés sur les 5 derniers mois
            $montants = $this->Operations->getLastOperations();
            $this->set('montants', $montants->toArray());
        }

        public function displayForUser($tier_id)
        {
            $this->loadModel('OperationsManager.Operations');

            $operations = $this->Operations->find()
                                           ->where(['tier_id' => $tier_id]);
            $this->set(compact('operations', 'tier_id'));
        }
    }

?>
