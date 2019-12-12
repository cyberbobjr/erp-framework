<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace CompaniesManager\Controller;

    use App\Model\Table\CompaniesTable;
    use Cake\Http\Exception\BadRequestException;
    use Cake\Http\Exception\NotFoundException;
    use Cake\Network\Response;

    /**
     * CakePHP BiensController
     * @author Benjamin
     * @property CompaniesTable $Societes
     *
     */
    class CompaniesController extends AppController
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
            $this->set('societes', $this->Societes->find('all'));
        }

        public function view($societes_id = NULL)
        {
            if (is_null($societes_id) || !$this->Societes->exists(['id' => $societes_id])) {
                throw new NotFoundException(__('Société non trouvée'));
            }
            $this->set('societe', $this->Societes->get($societes_id));
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
            $societes = $this->Societes->get($id);
            // Si la requête est de type post, put ou patch, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put',
                                    'patch'])
            ) {
                $this->Societes->patchEntity($societes, $this->request->getData());
                if ($this->Societes->save($societes)) {
                    $this->Flash->success(__('Societe mise à jour'));
                } else {
                    $this->Flash->error(__('Erreur lors de la mise à jour'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('societes'));
            $this->render('add');
        }

        /**
         * Fonction d'ajout d'un bien
         */
        public function add($id = NULL)
        {
            if (!is_null($id)) {
                $societes = $this->Societes->get($id);
            } else $societes = $this->Societes->newEntity($this->request->getData());

            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put'])
            ) {
                if (!is_null($id))
                    $this->Societes->patchEntity($societes, $this->request->getData()); else
                    $societes = $this->Societes->newEntity($this->request->getData());

                // on vérifie si les mots de passe sont identiques
                if ($this->Societes->save($societes)) {
                    // on créé le compte comptable associé
                    // récupération du compte parent rattaché au type de tiers
                    $this->Flash->success(__('Société enregistrée'));

                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('societes'));
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
            if ($this->Societes->exists(['id' => $id])) {
                $societes = $this->Societes->get($id);
                // on vérifie si le tiers possède un compte et des écritures
                if ($this->Societes->delete($societes)) {
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
                echo json_encode($data);
            }
        }

        /**
         * Génère un tableau des enregistrements sous format JSON
         */
        public function table()
        {
            $rows = $this->Societes->find('all', $this->options);
            $count = $rows->count();
            return new Response(['status' => 200,
                                 'body'   => json_encode(['total' => $count,
                                                          'rows'  => $rows])]);
        }

        /**
         * Fonction d'affichage pour les résultats
         *
         */
        public function resultats()
        {
            $societes = $this->Societes->find('list');
            $this->set(compact('societes'));
        }

        /**
         * Génère le compte de résultat de la société passée en référence
         * Cette fonction est appelée en AJAX
         * @param $societe_id
         */
        public function show_produits()
        {
            if ($this->request->is('ajax')) {
                $ecritures = [];
                $total = [];
                $this->autoRender = FALSE;
                $societe_id = $this->request->getData('societe_id');
                if (!is_null($societe_id)) {
                    $ecritures = $this->Societes->calcul_compte_produit($societe_id);
                    $total = $this->Societes->sum_compte_produit($societe_id);
                }
                echo json_encode(['rows'   => $ecritures,
                                  'footer' => [$total]]);
            } else {
                throw new BadRequestException(__('Accès direct non autorisé'));
            }
        }

        public function show_charges()
        {
            if ($this->request->is('ajax')) {
                $ecritures = [];
                $total = [];
                $this->autoRender = FALSE;
                $societe_id = $this->request->getData('societe_id');
                if (!is_null($societe_id)) {
                    $ecritures = $this->Societes->calcul_compte_charge($this->request->getData('societe_id'));
                    $total = $this->Societes->sum_compte_charge($societe_id);
                }
                echo json_encode(['rows'   => $ecritures,
                                  'footer' => [$total]]);
            } else {
                throw new BadRequestException(__('Accès direct non autorisé'));
            }

        }

        public function show_resultats()
        {

        }
    }