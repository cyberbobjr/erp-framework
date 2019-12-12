<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace OperationsManager\Controller;

    use App\Model\Table\TypeOperationDetailsTable;
    use Cake\Http\Exception\NotFoundException;
    use Cake\Network\Response;
    use Cake\ORM\TableRegistry;

    /**
     * Class TiersController
     * Gestion des types de tiers
     * Un type de tiers détermine le compte rattaché ainsi que les sens possible des opérations (débit, crédit ou les
     * deux)
     * @package App\Controller
     * @property \Cake\ORM\Table $TypeOperations
     */
    class TypeOperationsController extends AppController
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
         * Fonction d'édition d'un type d'opération
         * @param type $id
         */
        public function edit($id = NULL)
        {
            // on récupère la liste des comptes dans le plan comptable
            $plans = TableRegistry::get('Plans');
            $plans = $plans->find('treeList', ['spacer' => '-']);

            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            $typeoperations = $this->TypeOperations->get($id);
            // Si la requête est de type post, put ou patch, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put',
                                    'patch'])) {
                $this->TypeOperations->patchEntity($typeoperations, $this->request->getData());
                if ($this->TypeOperations->save($typeoperations)) {
                    $this->Flash->success(__('Type d\'opération mis à jour'));
                } else {
                    $this->Flash->error(__('Erreur lors de la mise à jour'));
                }
                $this->redirect(['action' => 'index']);
            }
            $this->set(compact('typeoperations', 'plans'));
            $this->render('add');
        }

        /**
         * Liste les types de tiers existants
         */
        public function index()
        {
            $this->set('type_operations', $this->TypeOperations->find());
        }

        /**
         * Fonction d'ajout d'un bien
         */
        public function add($id = NULL)
        {
            if (!is_null($id)) {
                $type_operation = $this->TypeOperations->get($id);
            } else $type_operation = $this->TypeOperations->newEntity($this->request->getData());

            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put'])) {
                if (!is_null($id))
                    $this->TypeOperations->patchEntity($type_operation, $this->request->getData()); else
                    $type_operation = $this->TypeOperations->newEntity($this->request->getData());

                // on vérifie si les mots de passe sont identiques
                if ($this->TypeOperations->save($type_operation)) {
                    // on créé le compte comptable associé
                    // récupération du compte parent rattaché au type de tiers
                    $this->Flash->success(__('Type enregistré'));

                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('type_operation'));
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
            if ($this->TypeOperations->exists(['id' => $id])) {
                $typeoperation = $this->TypeOperations->get($id);
                // on s'assure si le type est utilisé ou pas
                $operations = TableRegistry::get('Operations');
                if ($operations->isTypeExist($id)) {
                    $this->Flash->error(__('Le type d\'opération {0} est utilisé, il n\'est pas possible de le supprimer',
                        h($id)));
                } else {
                    if ($this->TypeOperations->delete($typeoperation)) {
                        $this->Flash->success(__('Le type d\'opération avec l\'id {0} a été supprimé.', h($id)));
                    } else {
                        $this->Flash->error(__('Erreur lors de la suppression du type de tier {0}', h($id)));
                    }
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le type d\'opération {0} n\'existe pas', h($id)));
                return $this->redirect(['action' => 'index']);
            }
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
                $data = $this->Publications->find('searched', [$tosearch])
                                           ->select(['value' => 'id',
                                                     'label' => 'titre',
                                                     'code'  => 'code']);
                $this->set('_serialize', $data);
            }
        }

        public function table()
        {
            $rows = $this->TypeOperations->find('all', $this->options);
            $count = $rows->count();
            return new Response(['status' => 200,
                                 'body'   => json_encode(['total' => $count,
                                                          'rows'  => $rows])]);
        }

    }
