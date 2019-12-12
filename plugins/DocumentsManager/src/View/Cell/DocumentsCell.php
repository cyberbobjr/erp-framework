<?php

namespace App\View\Cell;

use App\Model\Table\DocumentsTable;
use App\Model\Table\OperationsTable;
use Cake\View\Cell;

/**
 * Class DocumentsCell
 * @package App\View\Cell
 * @property DocumentsTable  $Documents
 * @property OperationsTable $Operations
 *
 */
class DocumentsCell extends Cell
{

    /**
     * Fonction d'affichage des documents pour une opération
     * @param $operation_id
     */
    public function display($operation_id)
    {
        $this->loadModel('Documents');
        $this->loadModel('Operations');
        $documents = $this->Documents->findByOperationId($operation_id);
        // récupération du client, afin de récupérer le mail
        $operation = $this->Operations->find('all')
                                      ->where(['Operations.id' => $operation_id])
                                      ->contain(['Clients'])
                                      ->first();
        $this->set(compact('documents', 'operation'));
    }

}

?>