<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace PropertiesManager\Controller;

    use Cake\Http\Exception\NotFoundException;
    use Cake\Network\Response;
    use PropertiesManager\Model\Table\PropertiesTable;

    /**
     * CakePHP BiensController
     * @author Benjamin
     * @property PropertiesTable $Properties
     */
    class PropertiesController extends AppController
    {

        /**
         * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
         *
         * @param type $user Paramètre représentant l'entité utilisateur
         * @return boolean TRUE si l'action est autorisée, FALSE si non
         */
        public function isAuthorized($user): bool
        {
            // Les compteurs utilisateurs ayant le rôle d'administrateur ont tous les droits
            return ($user) ? TRUE : FALSE;
        }

        /**
         * Affichage de la liste des biens
         * @param int $type Indique le filtre des tiers à afficher
         */
        public function index()
        {
            // execution de la requête
            $biens = $this->Properties->find()
                                      ->contain(['Companies',
                                                 'Leases']);
            $this->set(compact('biens'));
        }

        /**
         * Fonction d'édition d'un bien
         * @param type $id
         */
        public function edit($id = NULL)
        {
            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            $this->setAction('add', $id);

        }

        public function view($biens_id = NULL)
        {
            if (is_null($biens_id) || !$this->Properties->exists(['id' => $biens_id])) {
                throw new NotFoundException(__('Bien non trouvé'));
            }
            $this->set('bien', $this->Properties->get($biens_id));
        }

        /**
         * Fonction d'ajout d'un bien
         */
        public function add($id = NULL)
        {
            $societes = $this->Properties->Societes->find('list');
            if (is_null($id)) {
                $bien = $this->Properties->newEntity();
            } else {
                $bien = $this->Properties->get($id);
            }

            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put'])
            ) {
                if (!is_null($id)) {
                    $this->Properties->patchEntity($bien, $this->request->getData());
                } else {
                    $bien = $this->Properties->newEntity($this->request->getData());
                }

                // on vérifie si les mots de passe sont identiques
                if ($this->Properties->save($bien)) {
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
         * Fonction de suppression d'un bien
         * @param int $id identifiant du bien à supprimer
         * @throws NotFoundException
         */
        public function delete($id = NULL)
        {
            $result = FALSE;
            $msg = "";
            // si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence invalide'));
            }
            if ($this->Properties->exists(['id' => $id])) {
                $societes = $this->Properties->get($id);
                // on vérifie si le tiers possède un compte et des écritures
                if ($this->Properties->delete($societes)) {
                    $result = TRUE;
                    $msg = __('Le bien {0} a été supprimé', h($id));
                } else {
                    $msg = __('Erreur lors de la suppression');
                }
            } else {
                $msg = __('Le bien {0} n\'existe pas', h($id));
            }
            return new Response(['status' => 200,
                                 'body'   => json_encode(['result' => $result,
                                                          'msg'    => $msg])]);

        }
    }
