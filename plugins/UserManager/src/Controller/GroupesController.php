<?php

    namespace UserManager\Controller;

    use Cake\Datasource\Exception\RecordNotFoundException;
    use Cake\Datasource\ResultSetInterface;
    use Cake\Network\Exception\NotFoundException;
    use Cake\Network\Response;
    use UserManager\Model\Entity\Group;
    use UserManager\Model\Table\GroupsTable;
    use UserManager\Model\Table\RightsTable;

    /**
     * Groupes Controller
     *
     * @property GroupsTable $Groupes
     * @property RightsTable $Rights
     * @method Group[]|ResultSetInterface paginate($object = NULL, array $settings = [])
     */
    class GroupesController extends AppController
    {

        /**
         * Index method
         */
        public function index()
        {
            $groups = $this->paginate($this->Groupes);

            $this->set(compact('groups'));
            $this->set('_serialize', ['groups']);
        }

        /**
         * View method
         *
         * @param string|null $id Groupe id.
         * @throws RecordNotFoundException When record not found.
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
         * @return Response|void Redirects on successful edit, renders view otherwise.
         * @throws NotFoundException When record not found.
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
         * @return Response|null Redirects to index.
         * @throws RecordNotFoundException When record not found.
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
