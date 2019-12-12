<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace App\Controller;

    use Cake\Http\Exception\NotFoundException;
    use Cake\ORM\TableRegistry;

    /**
     * Class TypePaiementsController
     * Gestion des types de paiement
     * @package App\Controller
     */
    class TypePaymentsController extends AppController
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
         * Fonction d'édition d'un type de paiement
         * @param type $id
         */
        public function edit($id = NULL)
        {
            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            $typepaiements = $this->TypePaiements->get($id);
            // Si la requête est de type post, put ou patch, alors nous traitons les données reçues du formulaire
            if ($this->request->is([
                'post',
                'put',
                'patch'
            ])
            ) {
                $this->TypePaiements->patchEntity($typepaiements, $this->request->getData());
                if ($this->TypePaiements->save($typepaiements)) {
                    $this->Flash->success(__('Type de paiement mis à jour'));
                } else {
                    $this->Flash->error(__('Erreur lors de la mise à jour'));
                }
                $this->redirect(['action' => 'index']);
            }
            $this->set(compact('typepaiements'));
            $this->render('add');
        }

        /**
         * Liste les types de tiers existants
         */
        public function index()
        {
        }

        /**
         * Fonction d'ajout d'un tiers
         */
        public function add()
        {
            $typepaiements = $this->TypePaiements->newEntity($this->request->getData());
            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is([
                'post',
                'put'
            ])
            ) {
                // on vérifie si les mots de passe sont identiques
                if ($this->TypePaiements->save($typepaiements)) {
                    $this->Flash->success(__('Type de paiement enregistré'));
                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                $this->redirect(['action' => 'index']);
            }
            $this->set(compact('typepaiements'));

        }

        /**
         * Fonction de suppression d'un tiers
         * @param int $id identifiant du tiers à supprimer
         * @throws NotFoundException
         */
        public function delete($id = NULL)
        {
            // si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence invalide'));
            }
            if ($this->TypePaiements->exists(['id' => $id])) {
                $typepaiements = $this->TypePaiements->get($id);
                // on s'assure si le type est utilisé ou pas
                $paiements = TableRegistry::get('Paiements');
                if ($paiements->find('all')
                              ->where(['type_paiement_id' => $id])
                              ->count() > 0
                ) {
                    $this->Flash->error(__('Le type de paiement {0} est utilisé, il n\'est pas possible de le supprimer',
                        h($id)));
                } else {
                    if ($this->TypePaiements->delete($typepaiements)) {
                        $this->Flash->success(__('Le type de paiement avec l\'id {0} a été supprimé.', h($id)));
                    } else {
                        $this->Flash->error(__('Erreur lors de la suppression du type de paiement {0}', h($id)));
                    }
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le type de paiement {0} n\'existe pas', h($id)));
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
            $query = $this->TypePaiements->find('all')
                                         ->toArray();
            echo json_encode($query);
        }


    }
