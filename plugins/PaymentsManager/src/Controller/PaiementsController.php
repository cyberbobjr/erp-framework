<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace PaymentsManager\Controller;

    use Cake\Http\Exception\BadRequestException;
    use Cake\ORM\TableRegistry;

    /**
     * CakePHP BiensController
     * @author Benjamin
     */
    class PaiementsController extends AppController
    {

        /**
         * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
         *
         * @param type $user Paramètre représentant l'entité utilisateur
         * @return boolean TRUE si l'action est autorisée, FALSE si non
         */
        public function isAuthorized($user)
        {
            // Les compteurs utilisateurs ayant le rôle d'administrateur ont tous les droits
            if ($user) {
                return TRUE;
            }
            return FALSE;
        }

        /**
         * Affichage de la liste des biens
         * @param int $type Indique le filtre des tiers à afficher
         */
        public function index()
        {
        }

        /**
         * Fonction de suppression d'un paiement
         */
        public function delete()
        {
            $this->autoLayout = FALSE;
            if ($this->request->is('ajax')) {
                $ids = $this->request->getData('ids');
                foreach ($ids as $id) {
                    $paiement = $this->Paiements->get($id);
                    $this->Paiements->delete($paiement);
                }
                $this->Flash->growl(__('Paiement supprimé'), [
                    'key'    => 'growl',
                    'params' => ['class' => 'success']
                ]);
            } else {
                $this->Flash->error(__('Supression non autorisée'));
                return $this->redirect(['action' => 'index']);
            }
        }

        /**
         * Génère un tableau des enregistrements sous format JSON
         */
        public function table()
        {
            $this->autoRender = FALSE;
            $this->autoLayout = FALSE;
            $query = $this->Paiements->find('all')
                                     ->contain(['Societes',
                                                'Tiers',
                                                'Banques',
                                                'TypePaiements'])
                                     ->toArray();
            echo json_encode($query);
        }

        /**
         * Fonction d'ajout d'un paiement
         * @param int $type sens du paiement, 1 : du tiers vers la société, 2 : de la société vers le tiers
         */
        public function add($sens_banque = 1)
        {
            if ($sens_banque == 1 || $sens_banque == 2) {
                if ($sens_banque == 1) {
                    $sens_tiers = 2;
                } else {
                    $sens_tiers = 1;
                }
                // le sens du paiement est l'inverse du mouvement des opérations
                $this->request->withData('sens', $sens_banque);
                $paiements = $this->Paiements->newEntity($this->request->getData());
                // récupération des banques
                $banques = TableRegistry::get('Banques');
                $banques = $banques->find('list');
                // Récupération des types d'opérations au débit sur les comptes tiers
                $typepaiements = TableRegistry::get('TypePaiements');
                $typepaiements = $typepaiements->find('list');
                // Récupération des tiers à facturer ou dans les 2 sens
                $tiers = TableRegistry::get('Tiers');
                $tiers = $tiers->find('list')
                               ->contain(['TypeTiers'])
                               ->where([
                                   'or' => [
                                       ['TypeTiers.sens' => $sens_banque],
                                       ['TypeTiers.sens' => 3]
                                   ]
                               ]);
                // récupération des sociétés
                $societes = TableRegistry::get('societes');
                $societes = $societes->find('list')
                                     ->toArray();
                $this->set(compact('paiements', 'typepaiements', 'tiers', 'societes', 'banques'));
                if ($this->request->is([
                    'post',
                    'put'
                ])
                ) {
                    if ($this->Paiements->save($paiements)) {
                        // on génère les écritures associée au paiement
                        $tiers = TableRegistry::get('Tiers');
                        $banques = TableRegistry::get('Banques');
                        $tiers->enregistre_paiement($paiements->id, $sens_tiers);
                        $banques->enregistre_paiement($paiements->id, $sens_banque);

                        // on informe l'opération qu'un paiement a été réalisé
                        if (isset($paiements->operation_id) && !empty($paiements->operation_id)) {
                            $operations = TableRegistry::get('Operations');
                            $operations->enregistrement_paiement($paiements->operation_id);
                        }
                        $this->Flash->success(__('Le paiement a été enregistré'));
                    } else {
                        $this->Flash->error(__('Erreur lors de l\'enregistrement du paiement'));
                    }
                    $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('Erreur : Mauvais usage du type lors de la création du paiement'));
                return $this->redirect(['action' => 'index']);
            }
        }

        public function getbanques()
        {
            if ($this->request->is('ajax')) {
                $this->autoRender = FALSE;
                $id = $this->request->getData('id');
                $banques = TableRegistry::get('Banques');
                $banques = $banques->find('list', ['conditions' => ['societe_id' => $id]]);
                $this->set('_serialize', $banques);
            } else {
                throw new BadRequestException(__('Requête directe interdite'));
            }
        }
    }