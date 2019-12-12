<?php

    namespace UserManager\Controller;

    use UserManager\Model\Table\GroupesTable;
    use UserManager\Model\Table\RightsTable;

    /**
     * Groupes Controller
     *
     * @property GroupesTable $Groupes
     * @property RightsTable $Rights
     * @method \UserManager\Model\Entity\Groupe[]|\Cake\Datasource\ResultSetInterface paginate($object = NULL, array $settings = [])
     */
    class GroupesController extends AppController
    {

        /**
         * Index method
         */
        public function index()
        {
            $groupes = $this->paginate($this->Groupes);

            $this->set(compact('groupes'));
            $this->set('_serialize', ['groupes']);
        }

        /**
         * View method
         *
         * @param string|null $id Groupe id.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function view($id = NULL)
        {
            $groupe = $this->Groupes->get($id, ['contain' => ['Rights',
                                                              'Users']]);

            $this->set('groupe', $groupe);
            $this->set('_serialize', ['groupe']);
        }

        /**
         * Add method
         */
        public function add($id = NULL)
        {
            if (is_null($id)) {
                $groupe = $this->Groupes->newEntity();
            } else {
                $groupe = $this->Groupes->get($id, ['contain' => ['Users',
                                                                  'Rights']]);
            }
            if ($this->request->is(['post',
                                    'put'])
            ) {
                $groupe = $this->Groupes->patchEntity($groupe, $this->request->getData());
                if ($this->Groupes->save($groupe)) {
                    $this->Flash->success(__('Le groupe a été enregistré.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Erreur pendant la sauvegarde, recommencez s\'il vous plait.'));
                }
            }
            $rights = $this->Groupes->Rights->find('list', ['limit' => 200]);
            $users = $this->Groupes->Users->find('list', ['limit' => 200]);
            $this->set(compact('groupe', 'rights', 'users'));
            $this->set('_serialize', ['groupe']);
        }

        /**
         * Edit method
         *
         * @param string|null $id Groupe id.
         * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
         * @throws \Cake\Network\Exception\NotFoundException When record not found.
         */
        public function edit($id = NULL)
        {
            $groupe = $this->Groupes->get($id, ['contain' => ['Rights',
                                                              'Users']]);
            if ($this->request->is(['patch',
                                    'post',
                                    'put'])
            ) {
                $groupe = $this->Groupes->patchEntity($groupe, $this->request->getData());
                if ($this->Groupes->save($groupe)) {
                    $this->Flash->success(__('Le groupe a été enregistré.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Impossible d\'enregistrer le groupe'));
                }
            }
            $rights = $this->Groupes->Rights->find('list', ['limit' => 200]);
            $users = $this->Groupes->Users->find('list', ['limit' => 200]);
            $this->set(compact('groupe', 'rights', 'users'));
            $this->set('_serialize', ['groupe']);
        }

        /**
         * Delete method
         *
         * @param string|null $id Groupe id.
         * @return \Cake\Network\Response|null Redirects to index.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function delete($id = NULL)
        {
            $this->request->allowMethod(['delete']);
            $groupe = $this->Groupes->get($id);
            if ($this->Groupes->delete($groupe)) {
                $this->Flash->success(__('Le groupe a été supprimé.'));
            } else {
                $this->Flash->error(__('Ce groupe ne peut pas être supprimé.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }
