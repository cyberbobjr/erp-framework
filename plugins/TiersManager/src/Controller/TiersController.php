<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace TiersManager\Controller;

    use App\Model\Table\TiersTable;
    use Cake\Http\Exception\NotFoundException;
    use Cake\Network\Response;
    use Cake\ORM\TableRegistry;

    /**
     * Class TiersController
     * Gestion des tiers (clients, fournisseurs, banques, etc.)
     * @package App\Controller
     * @property TiersTable $Tiers
     */
    class TiersController extends AppController
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
         * Affichage de la liste des tiers
         * @param int $typetiers Indique le filtre des tiers à afficher
         */
        public function index($typetiers = NULL)
        {
            $this->set('typetiers', $typetiers);
        }


        /**
         * Fonction d'édition d'un tiers
         * @param type $id
         * @return Response|null
         * @throws NotFoundException
         */
        public function edit($id = NULL)
        {
            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            $tiers = $this->Tiers->get($id);
            // récupération des types de tiers
            $typetiers = TableRegistry::get('TypeTiers');
            $typetiers = $typetiers->find('list');
            // Si la requête est de type post, put ou patch, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put',
                                    'patch'])) {
                $this->Tiers->patchEntity($tiers, $this->request->getData());
                if ($this->Tiers->save($tiers)) {
                    $this->Flash->success(__('Tiers mis à jour'));
                } else {
                    $this->Flash->error(__('Erreur lors de la mise à jour'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('tiers', 'typetiers'));
            $this->render('add');
        }

        /**
         * Fonction d'ajout d'un bien
         */
        public function add($id = NULL)
        {
            $this->loadModel('TypeTiers');
            $typetiers = $this->TypeTiers->find('list');
            if (!is_null($id)) {
                $tier = $this->Tiers->get($id);
            } else $tier = $this->Tiers->newEntity($this->request->getData());

            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put'])) {
                if (!is_null($id))
                    $this->Tiers->patchEntity($tier, $this->request->getData()); else
                    $tier = $this->Tiers->newEntity($this->request->getData());

                // on vérifie si les mots de passe sont identiques
                if ($this->Tiers->save($tier)) {
                    // on créé le compte comptable associé
                    // récupération du compte parent rattaché au type de tiers
                    $this->Flash->success(__('Tier enregistré'));

                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                return $this->redirect(['action' => 'index',
                                        $tier->type_tier_id]);
            }
            $this->set(compact('tier', 'typetiers'));
        }

        /**
         * Fonction de suppression d'un tiers
         * @param int $id identifiant du tiers à supprimer
         * @return Response
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
            if ($this->Tiers->exists(['id' => $id])) {
                $societes = $this->Tiers->get($id);
                // on vérifie si le tiers possède un compte et des écritures
                if ($this->Tiers->delete($societes)) {
                    $result = TRUE;
                    $msg = __('Le tiers {0} a été supprimé', h($id));
                } else {
                    $msg = __('Erreur lors de la suppression');
                }
            } else {
                $msg = __('Le tiers {0} n\'existe pas', h($id));
            }
            return new Response(['status' => 200,
                                 'body'   => json_encode(['result' => $result,
                                                          'msg'    => $msg])]);

        }

        /**
         * Fonction utilisée par la barre de recherche dans la navbar, cette fonction permet d'afficher la liste des
         * tiers et retourne le résultat pour AJAX (en format json)
         * @uses string $tosearch La valeur recherchée, cette valeur est cherchée ensuite sur les champs nom, raison
         *     sociale
         */
        public function search()
        {
            if ($this->request->is('ajax')) {
                $this->autoRender = FALSE;
                $tosearch = $this->request->getQuery('term');
                $data = $this->Publications->find('searched', [$tosearch])
                                           ->select(['value' => 'id',
                                                     'label' => 'titre',
                                                     'code'  => 'code']);
                $this->set('_serialize', $data);
            }
        }

        /**
         * Génère un tableau des enregistrements sous format JSON
         */
        public function table()
        {
            $typetier_id = $this->request->getData('typetier_id');
            $rows = $this->Tiers->find('all', $this->options)
                                ->where(['type_tier_id' => $typetier_id])
                                ->contain(['TypeTiers']);
            $count = $rows->count();
            $this->set('total', $count);
            $this->set('rows', $rows);
            $this->set('_serialize', ['total',
                                      'rows']);
        }

        public function view($tier_id)
        {
            $this->loadModel('TypeDocumentstiers');
            $tier = $this->Tiers->find('all')
                                ->where(['id' => $tier_id])
                                ->contain(['Operations',
                                           'Documentstiers'])
                                ->first();
            $this->set('type_documentstiers', $this->TypeDocumentstiers->find('list'));
            $this->set(compact('tier'));
        }
    }
