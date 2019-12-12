<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace LeasesManager\Controller;

    use Cake\Http\Exception\NotFoundException;
    use Cake\ORM\TableRegistry;

    /**
     * CakePHP BiensController
     * @author Benjamin
     */
    class LeasesController extends AppController
    {

        /**
         * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
         *
         * @param  type  $user  Paramètre représentant l'entité utilisateur
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
         * @param  int  $type  Indique le filtre des tiers à afficher
         */
        public function index()
        {
        }

        /**
         * Fonction d'édition d'un loyer
         * @param  type  $id
         */
        public function edit($id = NULL)
        {
            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            $this->setAction('add',
                $id);

        }

        /**
         * Fonction d'ajout d'un loyer
         */
        public function add($id = NULL)
        {
            $societes = TableRegistry::get('Societes');
            $societes = $societes->find('list');
            if (!is_null($id)) {
                $bien = $this->Biens->get($id);
            } else {
                $bien = $this->Biens->newEntity($this->request->getData());
            }

            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is([
                'post',
                'put'
            ])
            ) {
                if (!is_null($id)) {
                    $this->Biens->patchEntity($bien, $this->request->getData());
                } else {
                    $bien = $this->Biens->newEntity($this->request->getData());
                }

                // on vérifie si les mots de passe sont identiques
                if ($this->Biens->save($bien)) {
                    // on créé le compte comptable associé
                    // récupération du compte parent rattaché au type de tiers
                    $this->Flash->success(__('Bien enregistré'));

                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('bien', 'societes'));
        }

        /**
         * Fonction de suppression d'un loyer
         * @param  int  $id  identifiant du loyer à supprimer
         * @throws NotFoundException
         */
        public
        function delete(
            $id = NULL
        ) {
            // si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence invalide'));
            }
            if ($this->Biens->exists(['id' => $id])) {
                $tiers = $this->Biens->get($id);
                // on vérifie si le tiers possède un compte et des écritures
                if ($this->Biens->canDelete($id)) {
                    if ($this->Biens->delete($tiers)) {
                        $this->Flash->success(__('Le bien avec l\'id {0} a été supprimé.', h($id)));
                    } else {
                        $this->Flash->error(__('Erreur lors de la suppression du bien {0}', h($id)));
                    }
                } else {
                    $this->Flash->error(__('Le bien ne doit plus être associé à un bail actif', h($id)));
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le bien {0} n\'existe pas', h($id)));
                return $this->redirect(['action' => 'index']);
            }
        }

    }
