<?php

    namespace OperationsManager\Controller;
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    use Cake\Database\Type;
    use Cake\Http\Exception\NotFoundException;
    use Cake\Network\Response;
    use Cake\View\CellTrait;
    use OperationsManager\Model\Entity\Operation;

    /**
     * CakePHP BiensController
     * @property \App\Model\Table\TypeOperationDetailsTable $TypeOperations
     * @property \App\Model\Table\VatsTable $tvas
     * @property \OperationsManager\Model\Table\OperationsTable $Operations
     * @author Benjamin
     * @property \App\Model\Table\VatsTable $Tvas
     */
    class OperationsController extends AppController
    {
        use CellTrait;

        /**
         * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
         *
         * @param type $user Paramètre représentant l'entité utilisateur
         * @return boolean TRUE si l'action est autorisée, FALSE si non
         */
        public function isAuthorized($user)
        {
            // Les compteurs utilisateurs ayant le rôle d'administrateur ont tous les droits
            return ($user) ? TRUE : FALSE;
        }

        /**
         * Affichage de la liste des biens
         */
        public function index()
        {
            $operations = $this->Operations->getAllOperations();
            $this->set(compact('operations'));
        }

        /**
         * Fonction utilisée par la barre de recherche dans la navbar, cette fonction permet d'afficher la liste des
         * tiers et retourne le résultat pour AJAX (en format json)
         * @param string $tosearch La valeur recherchée, cette valeur est cherchée ensuite sur les champs nom, raison
         *     sociale
         */
        public function search()
        {
            if ($this->request->is('ajax')) {
                $this->autoRender = FALSE;
                $tosearch = $this->request->getQuery('term');
                $data = $this->Societes->find('searched', [$tosearch])
                                       ->select(['value' => 'id',
                                                 'label' => 'titre',
                                                 'code'  => 'code']);
                $this->set('_serialize', $data);
            }
        }

        /**
         * Etape initiale de création d'une opération (facture ou appel de loyer)
         * Cette étape initiale permet de créér une référence d'opération rapidement à partir des informations fournies à
         * la base
         */
        public function step1()
        {
            $operation = new Operation();
            $this->_getCustomersForList();
            $this->_getCompaniesForList();
            $this->_getTypeOpsForList();
            if ($this->request->is(['post',
                                    'put'])
            ) {
                $operation = $this->Operations->newEntity($this->request->getData());
                if ($this->Operations->save($operation, ['associated' => ['Operationdetails']])) {
                    $this->Flash->success(__('Opération sauvegardée'));
                    $this->redirect(['action' => 'add',
                                     $operation->id]);
                } else {
                    $this->Flash->error(__('Erreur lors de la sauvegarde'));
                }
            }
            $this->set(compact('operation'));
        }

        private function _getCustomersForList()
        {
            $tiers = $this->Operations->getCustomersList();
            $this->set(compact('tiers'));
        }

        private function _getCompaniesForList()
        {
            $societes = $this->Operations->getCompaniesList();
            $this->set(compact('societes'));
        }

        private function _getTypeOpsForList()
        {
            $type_ops = $this->Operations->getTypeOpsList();
            $this->set(compact('type_ops'));
        }

        /**
         * Valide une opération,
         * une fois l'opération validée, elle est "active" : soumise aux informations de paiements
         * @param null $operation_id
         */
        public function validate($operation_id = NULL)
        {
            $this->request->allowMethod('post');
            if (is_null($operation_id) || !($this->Operations->exists(['id' => $operation_id]))) {
                throw new NotFoundException(__('Enregistrement inexistant'));
            }
            if ($this->Operations->setOpen($operation_id)) {
                $this->Flash->success(__('Opération validée'));
            } else {
                $this->Flash->error(__('Erreur lors de la validation'));
            }
            // génération de l'appel
            $this->redirect(['action' => 'add',
                             $operation_id]);
        }

        /**
         * Fonction pour passer une opération en "abandonnée"
         * @param int $operation_id Référence de l'opération à abandonner
         */
        public function cancel($operation_id = NULL)
        {
            $this->request->allowMethod('post');
            if (is_null($operation_id) || !($this->Operations->exists(['id' => $operation_id]))) {
                throw new NotFoundException(__('Enregistrement inexistant'));
            }
            // on indique que l'opération a été abandonnée
            if ($this->Operations->setCancel($operation_id)) {
                $this->Flash->success(__('L\'opération a été abandonnée'));
            } else {
                $this->Flash->error(__('Erreur lors de l\'abandon de l\'opération'));
            }
            $this->redirect(['action' => 'add',
                             $operation_id]);
        }

        /**
         * Réouvre une opération et la passe à brouillon
         * @param int $operation_id Référence de l'opération à réouvrir
         */
        public function reOpen($operation_id = NULL)
        {
            $this->request->allowMethod('post');
            if (is_null($operation_id) || !($this->Operations->exists(['id' => $operation_id]))) {
                throw new NotFoundException(__('Enregistrement inexistant'));
            }
            $this->Operations->reOpen($operation_id);
            $this->Flash->success(__('L\'opération a été réouverte'));
            $this->redirect(['action' => 'add',
                             $operation_id]);
        }

        public function reDraft($operation_id = NULL)
        {
            $this->request->allowMethod('post');
            if (is_null($operation_id) || !($this->Operations->exists(['id' => $operation_id]))) {
                throw new NotFoundException(__('Enregistrement inexistant'));
            }
            $this->Operations->setDraft($operation_id);
            $this->Flash->success(__('L\'opération a été repassée en brouillon'));
            $this->redirect(['action' => 'add',
                             $operation_id]);
        }

        /**
         * Fonction d'ajout d'une quittance ou de réception de facture
         * Par défaut, si rien n'est précisé c'est une quittance qui est générée
         * @param int $operation_id Référence de l'opération concernée par l'édition
         * @return Response|null
         */
        public function add($operation_id = NULL)
        {
            if (is_null($operation_id) || !($this->Operations->exists(['id' => $operation_id]))) {
                throw new NotFoundException(__('Enregistrement inexistant'));
            }

            // récupération de l'opération
            $operation = $this->Operations->getOperationById($operation_id);
            if ($this->request->is(['post',
                                    'put'])
            ) {
                $operation = $this->Operations->patchEntity($operation, $this->request->getData());
                if ($this->Operations->save($operation)) {
                    $this->Flash->success(__('Opération sauvegardée'));
                } else {
                    $this->Flash->error(__('Erreur lors de la sauvegarde'));
                }
            }
            $this->_setList($operation);
            $this->set(compact('operation'));
        }

        private function _setList($operation)
        {
            $societes = $this->Operations->Companies->find('list');
            $type_ops = $this->Operations->TypeOpsStates->find('list');
            $tiers = $this->Operations->Customers->find('list');
            $bails = $this->Operations->Leases->find('list')
                                              ->where(['tier_id' => $operation->tier_id,
                                                       'actif'   => TRUE]);
            $typeoperations = $this->Operations->TypeOperations->find('list');
            $this->loadModel('Tvas');
            $tvas = $this->Tvas->find('list');

            $this->set(compact('tiers', 'bails', 'typeoperations', 'tvas', 'type_ops', 'societes'));

        }

        /**
         * @param null $operation_id
         */
        public function supprimer($operation_id = NULL)
        {
            if (is_null($operation_id) || !($this->Operations->exists(['id' => $operation_id]))) {
                throw new NotFoundException(__('Référence de l\'opération invalide'));
            }
            // on ne peut pas supprimer une opération qui n'est pas en brouillon
            $operation = $this->Operations->get($operation_id);
            if (!$operation->is_draft) {
                $this->Flash->error(__('Il est impossible de supprimer une opération tant qu\'elle n\'a pas le statut brouillon'));
                $this->redirect($this->referer(['action' => 'add',
                                                $operation_id]));
            }

            if ($this->Operations->delete($operation)) {
                $this->Flash->success(__('Opération supprimée'));
            } else {
                $this->Flash->error(__('Erreur lors de la suppression de l\'opération'));
            }
            $this->redirect(['controller' => 'operations',
                             'action'     => 'index']);
        }

        public function quittance($operation_id)
        {
            $operation = $this->Operations->get($operation_id, ['contain' => ['Operationdetails',
                                                                              'Operationdetails.TypeOperations',
                                                                              'Clients',
                                                                              'Bails',
                                                                              'Bails.Societes',
                                                                              'Bails.TypePeriodicites',
                                                                              'Bails.Biens']]);
            $this->set(compact('operation'));
        }

        /**
         * Regenère les documents PDF d'une opération
         * @param int $operation_id Référence de l'opération
         * @return Response|void
         */
        public function regenerer($operation_id = NULL)
        {
            if (is_null($operation_id) || !$this->Operations->exists(['id' => $operation_id])) {
                throw new NotFoundException(__('Référence inexistante'));
            }
            if ($this->generer_doc_pdf($operation_id)) {
                $this->Flash->success(__('Fichiers générés'));
            } else {
                $this->Flash->error(__('Aucun fichier généré'));
            }
            $this->redirect(['action' => 'add',
                             $operation_id]);
        }

        /**
         * Fonction de suppression d'un bien
         * @param int $id identifiant du bien à supprimer
         * @return Response
         * @throws NotFoundException
         */
        public function delete($id = NULL)
        {
            $this->request->allowMethod('post');
            $result = FALSE;
            // si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence invalide'));
            }
            if ($this->Operations->exists(['id' => $id])) {
                $operation = $this->Operations->get($id);
                // on vérifie si le tiers possède un compte et des écritures
                if ($this->Operations->delete($operation)) {
                    $result = TRUE;
                    $msg = __('Enregistrement supprimé', h($id));
                } else {
                    $msg = __('Erreur lors de la suppression');
                }
            } else {
                $msg = __('La référence n\'existe pas', h($id));
            }
            $this->set(compact('result', 'msg'));
            $this->set('_serialize', ['result',
                                      'msg']);
        }

        public function test()
        {
            $this->viewBuilder()
                 ->setLayout(FALSE);
            $operation = $this->Operations->get(175);
            $this->set(compact('operation'));
        }
    }
