<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    namespace CustomersManager\Controller;

    use Cake\Http\Exception\NotFoundException;
    use Cake\ORM\TableRegistry;

    /**
     * Class TiersController
     * Gestion des types de tiers
     * Un type de tiers détermine le compte rattaché ainsi que les sens possible des opérations (débit, crédit ou les
     * deux)
     * @package App\Controller
     */
    class TypeTiersController extends AppController
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
         * Fonction d'édition d'un type tiers
         * @param type $id
         */
        public function edit($id = NULL)
        {
            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            $typetiers = $this->TypeTiers->get($id);
            // on récupère la liste des comptes dans le plan comptable
            $plans = TableRegistry::get('Plans');
            $list = $plans->find('treeList', ['spacer' => '-']);
            // Si la requête est de type post, put ou patch, alors nous traitons les données reçues du formulaire
            if ($this->request->is([
                'post',
                'put',
                'patch'
            ])
            ) {
                $this->TypeTiers->patchEntity($typetiers, $this->request->getData());
                if ($this->TypeTiers->save($typetiers)) {
                    $this->Flash->success(__('Type de tiers mis à jour'));
                } else {
                    $this->Flash->error(__('Erreur lors de la mise à jour'));
                }
                $this->redirect(['action' => 'index']);
            }
            $this->set(compact('typetiers', 'list'));
            $this->render('add');
        }

        /**
         * Liste les types de tiers existants
         */
        public function index()
        {
            $typetiers = $this->TypeTiers->find('all')
                                         ->contain(['Plans']);
            $this->set(compact('typetiers'));
        }

        /**
         * Fonction d'ajout d'un tiers
         */
        public function add()
        {
            $typetiers = $this->TypeTiers->newEntity($this->request->getData());
            // on récupère la liste des comptes dans le plan comptable
            $plans = TableRegistry::get('Plans');
            $list = $plans->find('treeList', ['spacer' => '-']);

            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is([
                'post',
                'put'
            ])
            ) {
                // on vérifie si les mots de passe sont identiques
                if ($this->TypeTiers->save($typetiers)) {
                    $this->Flash->success(__('Type de tiers enregistré'));
                } else {
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
                $this->redirect(['action' => 'index']);
            }
            $this->set(compact('typetiers', 'list'));

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
            if ($this->TypeTiers->exists(['id' => $id])) {
                $typetier = $this->TypeTiers->get($id);
                // on s'assure si le type est utilisé ou pas
                $tiers = TableRegistry::get('Tiers');
                if ($tiers->isTypeTierExist($id)) {
                    $this->Flash->error(__('Le type de tier {0} est utilisé, il n\'est pas possible de le supprimer', h($id)));
                } else {
                    if ($this->TypeTiers->delete($typetier)) {
                        $this->Flash->success(__('Le type de tier avec l\'id {0} a été supprimé.', h($id)));
                    } else {
                        $this->Flash->error(__('Erreur lors de la suppression du type de tier {0}', h($id)));
                    }
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le type de tier {0} n\'existe pas', h($id)));
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
                                           ->select(
                                               [
                                                   'value' => 'id',
                                                   'label' => 'titre',
                                                   'code'  => 'code'
                                               ]);
                $this->set('_serialize', $data);
            }
        }


    }
