<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace PaymentsManager\Controller;

    use App\Model\Table\OperationsPaymentsTable;
    use Cake\Http\Exception\ForbiddenException;
    use Cake\Network\Response;
    use Cake\View\CellTrait;

    /**
     * CakePHP ReglementsController
     * @property \App\Model\Table\ReglementsTable $Reglements
     * @property OperationsPaymentsTable $OperationsReglements
     * @author Benjamin
     */
    class ReglementsController extends AppController
    {
        use CellTrait;

        public function index()
        {
            $reglements = $this->Reglements->find('filter', ['query' => $this->request->getQuery()])
                                           ->order(['Reglements.date' => 'DESC']);
            $this->set(compact('reglements'));
        }

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
         * Affiche une page d'ajout de réglement pour le tier passé en paramètre
         * La page affiche toutes les opérations en attente de paiement
         *
         * @param $tier_id
         * @return Response|null
         * @throws \App\Controller\ForbiddenException
         */
        public function add($tier_id)
        {
            // récupération de toutes les opérations payable, les factures abandonnées ou cloturées ne sont pas récupérées
            $this->loadModel('Clients');
            $this->loadModel('Bails');
            $clients = $this->Clients->find('list');
            // récupération des types de paiement
            $type_paiements = $this->Reglements->TypePaiements->find('list');
            // on récupère les bails rattachés, donc les sociétés, donc les banques
            $banques = $this->Reglements->Banques->find('list')
                                                 ->matching('Societes.Bails.Clients', function ($q) use ($tier_id) {
                                                     return $q->where(['Clients.id' => $tier_id]);
                                                 });
            $reglement = $this->Reglements->newEntity($this->request->getData(), ['associated' => ['Operations']]);
            $operations = $this->Reglements->Operations->find('unpaid')
                                                       ->where(['tier_id' => $tier_id])
                                                       ->contain(['Clients']);
            if ($this->request->is(['post',
                                    'put'])) {
                if ($this->Reglements->save($reglement, ['associated' => ['Operations']])) {
                    $this->Flash->success(__('Réglement enregistré'));
                    if ($operations->count() == 0) {
                        $this->redirect(['controller' => 'tiers',
                                         'action'     => 'view',
                                         $tier_id]);
                    } else {
                        $this->redirect(['controller' => 'reglements',
                                         'action'     => 'add',
                                         $tier_id]);
                    }
                } else {
                    $this->Flash->error(__('Erreur lors de l\'enregistrement du réglement'));
                }
            }
            $this->set(compact('operations', 'banques', 'type_paiements', 'tier_id', 'clients', 'reglement'));
        }

        /**
         * Fonction de suppression d'un réglement
         * @param int $operations_reglements_id Référence du réglement à supprimer
         * @return Response
         */
        public function delete($operations_reglements_id)
        {
            $type = 'danger';
            $msg = __('Erreur de suppression');
            if (!$this->request->is('ajax')) {
                throw new ForbiddenException(__('Accès non autorisé'));
            }
            $this->loadModel('OperationsReglements');
            $this->loadModel('Operations');
            $entite = $this->OperationsReglements->get($operations_reglements_id);
            $reglement_id = $entite->reglement_id;
            if ($this->OperationsReglements->supprimer($operations_reglements_id)) {
                // si plus aucun réglement n'est rattaché, on peut supprimer également le réglement global
                if ($this->OperationsReglements->find('all')
                                               ->where(['reglement_id' => $reglement_id])
                                               ->count() == 0) {
                    $reglement = $this->Reglements->get($reglement_id);
                    $this->Reglements->delete($reglement);
                }
                $type = 'success';
                $msg = __('Réglement supprimé');
            }
            return new Response(['status' => 200,
                                 'body'   => json_encode(['type' => $type,
                                                          'msg'  => $msg])]);
        }

        /**
         * Liste les réglements associés à une opération
         * @param int $operation_id Référence de l'opération
         * @return Response
         */
        public function listReglements($operation_id)
        {
            $query = $this->Reglements->OperationsReglements->find()
                                                            ->contain(['Reglements',
                                                                       'Reglements.Banques',
                                                                       'Reglements.TypePaiements'])
                                                            ->where(['OperationsReglements.operation_id' => $operation_id]);
            $rows = $query->toArray();
            $sum = $query->select(['montant' => $query->func()
                                                      ->sum('montant')])
                         ->first();
            $count = $query->count();
            $this->set('total', $count);
            $this->set('footer', $sum->toArray());
            $this->set('rows', $rows);
            $this->set('_serialize', ['total',
                                      'footer',
                                      'rows']);
        }

        /**
         * Liste les réglements associés à un tiers
         * @param int $tier_id Référence du tiers concerné
         * @return Response
         */
        public function liste_reglements_tier($tier_id = NULL)
        {
            $this->loadModel('OperationsReglements');
            $query = $this->OperationsReglements->find('all')
                                                ->contain(['Operations',
                                                           'Operations.Tiers',
                                                           'Reglements',
                                                           'Reglements.Banques',
                                                           'Reglements.TypePaiements'])
                                                ->where(['Operations.tier_id' => $tier_id]);
            $rows = $query->toArray();
            $sum = $query->select(['montant' => $query->func()
                                                      ->sum('montant')])
                         ->first();
            $count = $query->count();
            $this->set('total', $count);
            $this->set('footer', $sum->toArray());
            $this->set('rows', $rows);
            $this->set('_serialize', ['total',
                                      'footer',
                                      'rows']);
        }
    }

    ?>