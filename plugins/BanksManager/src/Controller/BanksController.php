<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace BanksManager\Controller;

    use App\Model\Table\BanksTable;
    use Cake\Http\Exception\NotFoundException;
    use Cake\ORM\TableRegistry;

    /**
     * CakePHP BiensController
     * @author Benjamin
     * @property BanksTable $Banques
     */
    class BanksController extends AppController
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
            return ($user) ? TRUE : FALSE;
        }

        /**
         * Affichage de la liste des banques
         * @param int $type Indique le filtre des banques à afficher
         */
        public function index()
        {
            // execution de la requête
            $banques = $this->Banques->find();
            $this->set(compact('banques'));
        }

        /**
         * Fonction de suppression d'une banque
         * Appelée en AJAX, peut contenir plusieurs suppression possible
         */
        public function delete($id = NULL)
        {
            $result = FALSE;
            $msg = "";
            // si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence invalide'));
            }
            if ($this->Banques->exists(['id' => $id])) {
                $banque = $this->Banques->get($id);
                // on vérifie si le tiers possède un compte et des écritures
                if ($this->Banques->delete($banque)) {
                    $result = TRUE;
                    $msg = __('La banque {0} a été supprimé', h($id));
                } else {
                    $msg = __('Erreur lors de la suppression');
                }
            } else {
                $msg = __('Le bail {0} n\'existe pas', h($id));
            }
            $this->set('_serialize', compact('result', 'msg'));

        }

        /**
         * Fonction d'édition d'une banque
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

        /**
         * Fonction d'ajout d'un tiers
         */
        public function add($id = NULL)
        {
            $societes = TableRegistry::get('Societes');
            $societes = $societes->find('list');
            if (!is_null($id)) {
                $banque = $this->Banques->get($id);
            } else $banque = $this->Banques->newEntity();
            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put'])) {
                if (!is_null($id))
                    $this->Banques->patchEntity($banque, $this->request->getData()); else
                    $banque = $this->Banques->newEntity($this->request->getData());
                // on vérifie si les mots de passe sont identiques
                if ($this->Banques->save($banque)) {
                    $this->Flash->success(__('Banque enregistrée'));
                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('banque', 'societes'));
        }

        /**
         * Génère un tableau des enregistrements sous format JSON
         */
        public function table()
        {
            $rows = $this->Banques->find('all', $this->options)
                                  ->contain(['Societes']);
            $count = $rows->count();
            $this->set('_serialize', ['total' => $count,
                                      'rows'  => $rows]);
        }

        public function view($banque_id)
        {

        }
    }